<?php

namespace App\Services;

use App\Models\ProdutoInsercao;
use App\Models\PrecoInsercao;
use Illuminate\Support\Facades\DB;
use Exception;

class SincronizacaoService
{
    public function sincronizarProdutos()
    {
        try {
            $produtosTransformados = DB::table('v_produtos_transformados')->get();
            
            $contador = 0;
            foreach ($produtosTransformados as $produto) {
                ProdutoInsercao::updateOrCreate(
                    ['codigo' => $produto->codigo],
                    [
                        'nome' => $produto->nome,
                        'categoria' => $produto->categoria,
                        'subcategoria' => $produto->subcategoria,
                        'descricao' => $produto->descricao,
                        'fabricante' => $produto->fabricante,
                        'modelo' => $produto->modelo,
                        'cor' => $produto->cor,
                        'peso' => $produto->peso,
                        'largura' => $produto->largura,
                        'altura' => $produto->altura,
                        'profundidade' => $produto->profundidade,
                        'unidade' => $produto->unidade,
                        'data_cadastro' => $produto->data_cadastro,
                    ]
                );
                $contador++;
            }

            return [
                'sucesso' => true,
                'mensagem' => "Produtos sincronizados com sucesso",
                'quantidade' => $contador
            ];
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => "Erro ao sincronizar produtos: " . $e->getMessage(),
                'quantidade' => 0
            ];
        }
    }

    public function sincronizarPrecos()
    {
        try {
            $precosTransformados = DB::table('v_precos_transformados')->get();
            
            $contador = 0;
            foreach ($precosTransformados as $preco) {
                PrecoInsercao::updateOrCreate(
                    [
                        'codigo_produto' => $preco->codigo_produto,
                        'tipo_cliente' => $preco->tipo_cliente,
                    ],
                    [
                        'valor' => $preco->valor,
                        'moeda' => $preco->moeda,
                        'desconto_percentual' => $preco->desconto_percentual,
                        'acrescimo_percentual' => $preco->acrescimo_percentual,
                        'valor_promocional' => $preco->valor_promocional,
                        'data_inicio_promocao' => $preco->data_inicio_promocao,
                        'data_fim_promocao' => $preco->data_fim_promocao,
                        'data_atualizacao' => $preco->data_atualizacao,
                        'origem' => $preco->origem,
                        'vendedor_responsavel' => $preco->vendedor_responsavel,
                        'observacoes' => $preco->observacoes,
                    ]
                );
                $contador++;
            }

            return [
                'sucesso' => true,
                'mensagem' => "Preços sincronizados com sucesso",
                'quantidade' => $contador
            ];
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => "Erro ao sincronizar preços: " . $e->getMessage(),
                'quantidade' => 0
            ];
        }
    }
}

