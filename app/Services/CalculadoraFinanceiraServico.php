<?php

namespace App\Services;

use App\Models\Agendamento;
use Carbon\Carbon;

class CalculadoraFinanceiraServico
{
    private const TAXA_EMPRESA = 0.10;

    public function calcular(Agendamento $agendamento): array
    {
        $servico = $agendamento->servico;
        $valorTotal = (float) $servico->preco_base;

        if ($servico->tipo_preco === 'Hora') {
            $inicio = Carbon::parse($agendamento->data_hora_inicio);
            $fim = Carbon::parse($agendamento->data_hora_fim);
            $duracaoEmHoras = $inicio->diffInSeconds($fim) / 3600;
            $valorTotal *= $duracaoEmHoras;
        }

        $valorCentavos = (int) round($valorTotal * 100);
        $comissaoCentavos = (int) round($valorCentavos * self::TAXA_EMPRESA);

        return [
            'valor_total' => number_format($valorCentavos / 100, 2, '.', ''),
            'taxa_site' => number_format($comissaoCentavos / 100, 2, '.', ''),
            'comissao_empresa' => number_format($comissaoCentavos / 100, 2, '.', ''),
        ];
    }
}
