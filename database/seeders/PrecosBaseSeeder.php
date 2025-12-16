<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Precos;

class PrecosBaseSeeder extends Seeder
{
    private function normalizarValor($valor)
    {
        if (empty($valor) || $valor === 'sem preço') {
            return '0';
        }

        $valor = trim($valor);
        $valor = str_replace(' ', '', $valor);
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);

        return is_numeric($valor) ? (string) $valor : null;
    }

    private function normalizarPercentual($valor)
    {
        if (empty($valor) || $valor === '0' || $valor === 'NULL') {
            return null;
        }

        $valor = trim($valor);
        if (strpos($valor, '%') !== false) {
            $valor = str_replace('%', '', $valor);
        }

        return is_numeric($valor) ? (string) $valor : null;
    }

    private function normalizarData($data)
    {
        if (empty($data) || $data === 'NULL') {
            return null;
        }

        $data = trim($data);
        $data = str_replace(['/', '.'], '-', $data);

        if (preg_match('/(\d{2})-(\d{2})-(\d{4})/', $data, $matches)) {
            return $matches[3] . '-' . $matches[2] . '-' . $matches[1];
        }

        if (preg_match('/(\d{4})-(\d{2})-(\d{2})/', $data)) {
            return $data;
        }

        return null;
    }

    public function run()
    {
        $precos = [
            [
                'prc_cod_prod' => 'PRD001',
                'prc_valor' => $this->normalizarValor('499,90'),
                'prc_moeda' => 'BRL',
                'prc_desc' => $this->normalizarPercentual('5%'),
                'prc_acres' => $this->normalizarPercentual('0'),
                'prc_promo' => $this->normalizarValor('474,90'),
                'prc_dt_ini_promo' => $this->normalizarData('2025/10/10'),
                'prc_dt_fim_promo' => $this->normalizarData('2025-10-20'),
                'prc_dt_atual' => $this->normalizarData('2025-10-15'),
                'prc_origem' => 'SISTEMA ERP',
                'prc_tipo_cli' => 'VAREJO',
                'prc_vend_resp' => 'Marcos Silva',
                'prc_obs' => 'Produto em destaque',
                'prc_status' => 'ativo'
            ],
            [
                'prc_cod_prod' => 'PRD002',
                'prc_valor' => $this->normalizarValor('120.50'),
                'prc_moeda' => 'BRL',
                'prc_desc' => $this->normalizarPercentual('0'),
                'prc_acres' => $this->normalizarPercentual('0'),
                'prc_promo' => $this->normalizarValor('120.50'),
                'prc_dt_ini_promo' => $this->normalizarData('10-10-2025'),
                'prc_dt_fim_promo' => null,
                'prc_dt_atual' => $this->normalizarData('2025-10-16'),
                'prc_origem' => 'MIGRACAO',
                'prc_tipo_cli' => 'ATACADO',
                'prc_vend_resp' => 'Julia S.',
                'prc_obs' => null,
                'prc_status' => 'ativo'
            ],
            [
                'prc_cod_prod' => 'PRD003',
                'prc_valor' => $this->normalizarValor('1.099,00'),
                'prc_moeda' => 'BRL',
                'prc_desc' => $this->normalizarPercentual('10%'),
                'prc_acres' => null,
                'prc_promo' => $this->normalizarValor('989,10'),
                'prc_dt_ini_promo' => $this->normalizarData('2025.10.10'),
                'prc_dt_fim_promo' => $this->normalizarData('2025.10.25'),
                'prc_dt_atual' => $this->normalizarData('16/10/2025'),
                'prc_origem' => 'API INTERNA',
                'prc_tipo_cli' => 'VAREJO',
                'prc_vend_resp' => 'Carlos Souza',
                'prc_obs' => 'Desconto aplicado via API',
                'prc_status' => 'ativo'
            ],
            [
                'prc_cod_prod' => 'PRD004',
                'prc_valor' => $this->normalizarValor('899.99'),
                'prc_moeda' => 'BRL',
                'prc_desc' => '',
                'prc_acres' => $this->normalizarPercentual('5%'),
                'prc_promo' => null,
                'prc_dt_ini_promo' => $this->normalizarData('15/10/2025'),
                'prc_dt_fim_promo' => $this->normalizarData('30/10/2025'),
                'prc_dt_atual' => $this->normalizarData('2025/10/16'),
                'prc_origem' => 'ERP LEGADO',
                'prc_tipo_cli' => 'VAREJO',
                'prc_vend_resp' => 'Jéssica M.',
                'prc_obs' => 'Campanha de Outubro',
                'prc_status' => 'ativo'
            ],
            [
                'prc_cod_prod' => 'PRD005',
                'prc_valor' => $this->normalizarValor('0'),
                'prc_moeda' => 'BRL',
                'prc_desc' => '',
                'prc_acres' => '',
                'prc_promo' => '',
                'prc_dt_ini_promo' => '',
                'prc_dt_fim_promo' => '',
                'prc_dt_atual' => $this->normalizarData('2025-10-10'),
                'prc_origem' => 'ERP LEGADO',
                'prc_tipo_cli' => 'VAREJO',
                'prc_vend_resp' => 'Pedro L.',
                'prc_obs' => 'Sem preço cadastrado',
                'prc_status' => 'inativo'
            ],
            [
                'prc_cod_prod' => 'PRD006',
                'prc_valor' => $this->normalizarValor('389,90'),
                'prc_moeda' => 'BRL',
                'prc_desc' => $this->normalizarPercentual('15%'),
                'prc_acres' => $this->normalizarPercentual('2%'),
                'prc_promo' => $this->normalizarValor('331,42'),
                'prc_dt_ini_promo' => $this->normalizarData('2024.06.01'),
                'prc_dt_fim_promo' => $this->normalizarData('2024.06.30'),
                'prc_dt_atual' => $this->normalizarData('2024-05-28'),
                'prc_origem' => 'SISTEMA ERP',
                'prc_tipo_cli' => 'VAREJO',
                'prc_vend_resp' => 'Ana Costa',
                'prc_obs' => 'Promoção semestral',
                'prc_status' => 'ativo'
            ],
            [
                'prc_cod_prod' => 'PRD007',
                'prc_valor' => $this->normalizarValor('2.899,00'),
                'prc_moeda' => 'BRL',
                'prc_desc' => $this->normalizarPercentual('8%'),
                'prc_acres' => '',
                'prc_promo' => $this->normalizarValor('2.667,08'),
                'prc_dt_ini_promo' => $this->normalizarData('2024/04/15'),
                'prc_dt_fim_promo' => $this->normalizarData('2024/05/15'),
                'prc_dt_atual' => $this->normalizarData('2024-04-10'),
                'prc_origem' => 'API INTERNA',
                'prc_tipo_cli' => 'ATACADO',
                'prc_vend_resp' => 'Roberto Lima',
                'prc_obs' => 'Desconto por volume',
                'prc_status' => 'ativo'
            ],
            [
                'prc_cod_prod' => 'PRD008',
                'prc_valor' => $this->normalizarValor('1.899,00'),
                'prc_moeda' => 'BRL',
                'prc_desc' => $this->normalizarPercentual('12%'),
                'prc_acres' => $this->normalizarPercentual('3%'),
                'prc_promo' => $this->normalizarValor('1.671,12'),
                'prc_dt_ini_promo' => $this->normalizarData('2024-03-01'),
                'prc_dt_fim_promo' => $this->normalizarData('2024-03-31'),
                'prc_dt_atual' => $this->normalizarData('2024.02.25'),
                'prc_origem' => 'ERP LEGADO',
                'prc_tipo_cli' => 'VAREJO',
                'prc_vend_resp' => 'Fernanda R.',
                'prc_obs' => 'Liquidação estoque',
                'prc_status' => 'ativo'
            ],
            [
                'prc_cod_prod' => 'PRD009',
                'prc_valor' => $this->normalizarValor('299,90'),
                'prc_moeda' => 'BRL',
                'prc_desc' => $this->normalizarPercentual('20%'),
                'prc_acres' => $this->normalizarPercentual('0'),
                'prc_promo' => $this->normalizarValor('239,92'),
                'prc_dt_ini_promo' => $this->normalizarData('2024.05.20'),
                'prc_dt_fim_promo' => $this->normalizarData('2024.06.20'),
                'prc_dt_atual' => $this->normalizarData('2024/05/15'),
                'prc_origem' => 'SISTEMA ERP',
                'prc_tipo_cli' => 'ATACADO',
                'prc_vend_resp' => 'Carlos Santos',
                'prc_obs' => 'Queima de estoque',
                'prc_status' => 'ativo'
            ],
            [
                'prc_cod_prod' => 'PRD010',
                'prc_valor' => $this->normalizarValor('699,00'),
                'prc_moeda' => 'BRL',
                'prc_desc' => $this->normalizarPercentual('5%'),
                'prc_acres' => $this->normalizarPercentual('1%'),
                'prc_promo' => $this->normalizarValor('664,05'),
                'prc_dt_ini_promo' => $this->normalizarData('2024-04-01'),
                'prc_dt_fim_promo' => $this->normalizarData('2024-04-30'),
                'prc_dt_atual' => $this->normalizarData('2024-03-28'),
                'prc_origem' => 'API INTERNA',
                'prc_tipo_cli' => 'VAREJO',
                'prc_vend_resp' => 'Mariana O.',
                'prc_obs' => 'Promoção relâmpago',
                'prc_status' => 'ativo'
            ],
            [
                'prc_cod_prod' => 'PRD011',
                'prc_valor' => $this->normalizarValor('450,00'),
                'prc_moeda' => 'BRL',
                'prc_desc' => $this->normalizarPercentual('25%'),
                'prc_acres' => '',
                'prc_promo' => $this->normalizarValor('337,50'),
                'prc_dt_ini_promo' => $this->normalizarData('2024/06/10'),
                'prc_dt_fim_promo' => $this->normalizarData('2024/07/10'),
                'prc_dt_atual' => $this->normalizarData('2024.06.05'),
                'prc_origem' => 'ERP LEGADO',
                'prc_tipo_cli' => 'VAREJO',
                'prc_vend_resp' => 'Paulo H.',
                'prc_obs' => 'Dia dos namorados',
                'prc_status' => 'ativo'
            ],
            [
                'prc_cod_prod' => 'PRD012',
                'prc_valor' => $this->normalizarValor('0'),
                'prc_moeda' => 'BRL',
                'prc_desc' => '',
                'prc_acres' => '',
                'prc_promo' => '',
                'prc_dt_ini_promo' => '',
                'prc_dt_fim_promo' => '',
                'prc_dt_atual' => $this->normalizarData('2024-03-20'),
                'prc_origem' => 'SISTEMA ERP',
                'prc_tipo_cli' => 'VAREJO',
                'prc_vend_resp' => 'Lucas T.',
                'prc_obs' => 'Produto descontinuado',
                'prc_status' => 'inativo'
            ]
        ];

        Precos::insert($precos);
    }
}
