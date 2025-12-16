<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW v_produtos_transformados AS
            SELECT 
                prod_id as id_origem,
                UPPER(TRIM(prod_cod)) as codigo,
                INITCAP(TRIM(prod_nome)) as nome,
                INITCAP(TRIM(prod_cat)) as categoria,
                INITCAP(TRIM(prod_subcat)) as subcategoria,
                TRIM(prod_desc) as descricao,
                INITCAP(TRIM(prod_fab)) as fabricante,
                TRIM(prod_mod) as modelo,
                INITCAP(TRIM(prod_cor)) as cor,
                CASE 
                    WHEN TRIM(prod_peso) = '' OR prod_peso IS NULL THEN NULL
                    ELSE CAST(REPLACE(REGEXP_REPLACE(TRIM(prod_peso), '[^0-9,.]', '', 'g'), ',', '.') AS DECIMAL(10,3))
                END as peso,
                CASE 
                    WHEN TRIM(prod_larg) = '' OR prod_larg IS NULL THEN NULL
                    ELSE CAST(REPLACE(REGEXP_REPLACE(TRIM(prod_larg), '[^0-9,.]', '', 'g'), ',', '.') AS DECIMAL(10,2))
                END as largura,
                CASE 
                    WHEN TRIM(prod_alt) = '' OR prod_alt IS NULL THEN NULL
                    ELSE CAST(REPLACE(REGEXP_REPLACE(TRIM(prod_alt), '[^0-9,.]', '', 'g'), ',', '.') AS DECIMAL(10,2))
                END as altura,
                CASE 
                    WHEN TRIM(prod_prof) = '' OR prod_prof IS NULL THEN NULL
                    ELSE CAST(REPLACE(REGEXP_REPLACE(TRIM(prod_prof), '[^0-9,.]', '', 'g'), ',', '.') AS DECIMAL(10,2))
                END as profundidade,
                UPPER(TRIM(prod_und)) as unidade,
                CASE 
                    WHEN prod_dt_cad ~ '^[0-9]{4}-[0-9]{2}-[0-9]{2}$' THEN CAST(prod_dt_cad AS DATE)
                    WHEN prod_dt_cad ~ '^[0-9]{2}/[0-9]{2}/[0-9]{4}$' THEN TO_DATE(prod_dt_cad, 'DD/MM/YYYY')
                    WHEN prod_dt_cad ~ '^[0-9]{2}-[0-9]{2}-[0-9]{4}$' THEN TO_DATE(prod_dt_cad, 'DD-MM-YYYY')
                    WHEN prod_dt_cad ~ '^[0-9]{4}.[0-9]{2}.[0-9]{2}$' THEN TO_DATE(REPLACE(prod_dt_cad, '.', '-'), 'YYYY-MM-DD')
                    ELSE NULL
                END as data_cadastro
            FROM produtos_base
            WHERE prod_atv = true
        ");

        DB::statement("
            CREATE OR REPLACE VIEW v_precos_transformados AS
            SELECT 
                preco_id as id_origem,
                UPPER(TRIM(prc_cod_prod)) as codigo_produto,
                CASE 
                    WHEN prc_valor IS NULL OR prc_valor = '' OR prc_valor = 'sem preço' OR prc_valor = '0' THEN NULL
                    ELSE CAST(REPLACE(REPLACE(REPLACE(TRIM(prc_valor), ' ', ''), '.', ''), ',', '.') AS DECIMAL(15,2))
                END as valor,
                UPPER(TRIM(COALESCE(prc_moeda, 'BRL'))) as moeda,
                CASE 
                    WHEN prc_desc IS NULL OR prc_desc = '' OR prc_desc = '0' OR prc_desc = 'NULL' THEN NULL
                    ELSE CAST(REPLACE(REPLACE(TRIM(prc_desc), '%', ''), ',', '.') AS DECIMAL(5,2))
                END as desconto_percentual,
                CASE 
                    WHEN prc_acres IS NULL OR prc_acres = '' OR prc_acres = '0' OR prc_acres = 'NULL' THEN NULL
                    ELSE CAST(REPLACE(REPLACE(TRIM(prc_acres), '%', ''), ',', '.') AS DECIMAL(5,2))
                END as acrescimo_percentual,
                CASE 
                    WHEN prc_promo IS NULL OR prc_promo = '' OR prc_promo = 'sem preço' OR prc_promo = '0' THEN NULL
                    ELSE CAST(REPLACE(REPLACE(REPLACE(TRIM(prc_promo), ' ', ''), '.', ''), ',', '.') AS DECIMAL(15,2))
                END as valor_promocional,
                CASE 
                    WHEN prc_dt_ini_promo IS NULL OR prc_dt_ini_promo = '' OR prc_dt_ini_promo = 'NULL' THEN NULL
                    WHEN prc_dt_ini_promo ~ '^[0-9]{4}-[0-9]{2}-[0-9]{2}$' THEN CAST(prc_dt_ini_promo AS DATE)
                    WHEN prc_dt_ini_promo ~ '^[0-9]{2}/[0-9]{2}/[0-9]{4}$' THEN TO_DATE(prc_dt_ini_promo, 'DD/MM/YYYY')
                    WHEN prc_dt_ini_promo ~ '^[0-9]{2}-[0-9]{2}-[0-9]{4}$' THEN TO_DATE(prc_dt_ini_promo, 'DD-MM-YYYY')
                    WHEN prc_dt_ini_promo ~ '^[0-9]{4}.[0-9]{2}.[0-9]{2}$' THEN TO_DATE(REPLACE(prc_dt_ini_promo, '.', '-'), 'YYYY-MM-DD')
                    ELSE NULL
                END as data_inicio_promocao,
                CASE 
                    WHEN prc_dt_fim_promo IS NULL OR prc_dt_fim_promo = '' OR prc_dt_fim_promo = 'NULL' THEN NULL
                    WHEN prc_dt_fim_promo ~ '^[0-9]{4}-[0-9]{2}-[0-9]{2}$' THEN CAST(prc_dt_fim_promo AS DATE)
                    WHEN prc_dt_fim_promo ~ '^[0-9]{2}/[0-9]{2}/[0-9]{4}$' THEN TO_DATE(prc_dt_fim_promo, 'DD/MM/YYYY')
                    WHEN prc_dt_fim_promo ~ '^[0-9]{2}-[0-9]{2}-[0-9]{4}$' THEN TO_DATE(prc_dt_fim_promo, 'DD-MM-YYYY')
                    WHEN prc_dt_fim_promo ~ '^[0-9]{4}.[0-9]{2}.[0-9]{2}$' THEN TO_DATE(REPLACE(prc_dt_fim_promo, '.', '-'), 'YYYY-MM-DD')
                    ELSE NULL
                END as data_fim_promocao,
                CASE 
                    WHEN prc_dt_atual IS NULL OR prc_dt_atual = '' OR prc_dt_atual = 'NULL' THEN NULL
                    WHEN prc_dt_atual ~ '^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$' THEN CAST(prc_dt_atual AS TIMESTAMP)
                    WHEN prc_dt_atual ~ '^[0-9]{4}-[0-9]{2}-[0-9]{2}$' THEN CAST(prc_dt_atual AS TIMESTAMP)
                    WHEN prc_dt_atual ~ '^[0-9]{2}/[0-9]{2}/[0-9]{4}$' THEN TO_TIMESTAMP(prc_dt_atual, 'DD/MM/YYYY')
                    WHEN prc_dt_atual ~ '^[0-9]{2}-[0-9]{2}-[0-9]{4}$' THEN TO_TIMESTAMP(prc_dt_atual, 'DD-MM-YYYY')
                    WHEN prc_dt_atual ~ '^[0-9]{4}.[0-9]{2}.[0-9]{2}$' THEN TO_TIMESTAMP(REPLACE(prc_dt_atual, '.', '-'), 'YYYY-MM-DD')
                    ELSE NULL
                END as data_atualizacao,
                TRIM(prc_origem) as origem,
                UPPER(TRIM(prc_tipo_cli)) as tipo_cliente,
                TRIM(prc_vend_resp) as vendedor_responsavel,
                TRIM(prc_obs) as observacoes
            FROM precos_base
            WHERE prc_status = 'ativo'
        ");
    }

    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS v_precos_transformados');
        DB::statement('DROP VIEW IF EXISTS v_produtos_transformados');
    }
};
