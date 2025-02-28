<?php

namespace App\Services\Etapas;

use App\Models\ObraEtapasFinanceiro;
use App\Models\EtapasFaturamento;
use App\Models\ObraEtapa;
use Carbon\Carbon;

class FinanceiroService
{
    /**
     * Calcula informações financeiras completas para uma etapa financeira
     *
     * @param int $etapaFinanceiroId
     * @return array
     */
    public function calcularInfoFinanceira($etapaFinanceiroId)
    {
        $etapaFinanceira = ObraEtapasFinanceiro::findOrFail($etapaFinanceiroId);
        $faturamentos = EtapasFaturamento::where('obr_etp_financerio_id', $etapaFinanceira->id)->get();
        $obraEtapa = ObraEtapa::where('id_etapa', $etapaFinanceira->etapa_id)->first();

        $hoje = Carbon::now();

        // Valor total definido para a etapa
        $valorTotal = $etapaFinanceira->valor_receber;

        // Valores recebidos (status Y)
        $valorRecebido = $faturamentos->where('recebido_status', 'Y')->sum('valor');

        // Valores faturados (com NF emitida) mas ainda não recebidos
        $valorFaturadoNaoRecebido = $faturamentos->where('recebido_status', 'N')->sum('valor');

        // Total faturado (recebidos + a receber)
        $totalFaturado = $valorRecebido + $valorFaturadoNaoRecebido;

        // Quanto ainda falta faturar
        $aFaturar = $obraEtapa->check == 'C' ? max(0, $valorTotal - $totalFaturado) : 0;

        // Faturas vencidas (não recebidas e com data de vencimento no passado)
        $faturasVencidas = $faturamentos->filter(function ($fatura) use ($hoje) {
            return $fatura->recebido_status == 'N' && $fatura->data_vencimento < $hoje;
        });

        $valorVencido = $faturasVencidas->sum('valor_receber');
        $qtdVencidas = $faturasVencidas->count();

        // Faturas a vencer (não recebidas e com data de vencimento no futuro)
        $faturasAVencer = $faturamentos->filter(function ($fatura) use ($hoje) {
            return $fatura->recebido_status == 'N' && $fatura->data_vencimento >= $hoje;
        });

        // Próximo vencimento
        $proximoVencimento = null;
        if ($faturasAVencer->count() > 0) {
            $proximoVencimento = $faturasAVencer->sortBy('data_vencimento')->first()->data_vencimento;
        }

        return [
            'id' => $etapaFinanceira->id,
            'nome' => $etapaFinanceira->nome_etapa,
            'total_faturado' => ($totalFaturado),
            'a_faturar' => ($aFaturar),
            'a_receber' => ($valorFaturadoNaoRecebido),
            'recebido' => ($valorRecebido),
            'vencidas' => [
                'valor' => $valorVencido,
                'quantidade' => $qtdVencidas,
                'faturas' => $faturasVencidas
            ],
            'proximo_vencimento' => $proximoVencimento,
            'valor_total' => ($valorTotal),
            'percentual_recebido' => $valorTotal > 0 ? ($valorRecebido / $valorTotal * 100) : 0,
            'percentual_faturado' => $valorTotal > 0 ? ($totalFaturado / $valorTotal * 100) : 0,
            'status' => $etapaFinanceira->status,

            'status_etapa' => $etapaFinanceira->StatusEtapa['text'],
            'label_etapa' => $etapaFinanceira->StatusEtapa['label'],
        ];
    }
}
