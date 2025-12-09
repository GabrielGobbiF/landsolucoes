<?php

namespace App\Observers;

use App\Models\EtapasFaturamento;
use App\Models\ObraEtapasFinanceiro;
use Illuminate\Support\Facades\DB;

class EtapasFaturamentoObserver
{
    /**
     * Handle the EtapasFaturamento "created" event.
     *
     * @param  \App\Models\EtapasFaturamento  $etapasFaturamento
     * @return void
     */
    public function created(EtapasFaturamento $etapasFaturamento)
    {
        $this->verificarTotalFaturado($etapasFaturamento);
    }

    /**
     * Handle the EtapasFaturamento "updated" event.
     *
     * @param  \App\Models\EtapasFaturamento  $etapasFaturamento
     * @return void
     */
    public function updated(EtapasFaturamento $etapasFaturamento)
    {
        $this->verificarTotalFaturado($etapasFaturamento);
    }

    /**
     * Handle the EtapasFaturamento "deleted" event.
     *
     * @param  \App\Models\EtapasFaturamento  $etapasFaturamento
     * @return void
     */
    public function deleted(EtapasFaturamento $etapasFaturamento)
    {
        $this->verificarTotalFaturado($etapasFaturamento);
    }

    /**
     * Verifica se o total faturado atingiu o valor a receber e atualiza o status
     *
     * @param  \App\Models\EtapasFaturamento  $etapasFaturamento
     * @return void
     */
    private function verificarTotalFaturado(EtapasFaturamento $etapasFaturamento)
    {
        // Apenas verifica se o faturamento tem vínculo com uma etapa financeira
        if (!$etapasFaturamento->obr_etp_financerio_id) {
            return;
        }

        $etapaFinanceira = ObraEtapasFinanceiro::findOrFail($etapasFaturamento->obr_etp_financerio_id);

        // Calcula o total já faturado para esta etapa financeira
        $totalFaturado = EtapasFaturamento::where('obr_etp_financerio_id', $etapaFinanceira->id)
            ->where('recebido_status', 'Y')  // Considerar apenas faturas recebidas
            ->sum('valor');

        $aFaturar = $etapaFinanceira->valor_receber - $totalFaturado;

        // Compara com arredondamento para evitar problemas com números de ponto flutuante
        if (round($totalFaturado, 2) >= round($etapaFinanceira->valor_receber, 2)) {
            // Atualiza status na etapa financeira
            $etapaFinanceira->update(['status' => 'faturado']);

            // Se existir vínculo com uma etapa, atualiza a etapa também
            if ($etapaFinanceira->etapa_id) {
                DB::table('obras_etapas')
                    ->where('id', $etapaFinanceira->etapa_id)
                    ->update([
                        'status' => 'F',  // Faturado
                        'check' => 'C'    // Concluída
                    ]);
            }
        } else {
            // Caso o valor tenha sido reduzido (por exemplo, por exclusão de faturamento)
            $etapaFinanceira->update(['status' => 'parcial']);

            // Se existir vínculo com uma etapa, atualiza a etapa para parcial
            if ($etapaFinanceira->etapa_id) {
                DB::table('obras_etapas')
                    ->where('id', $etapaFinanceira->etapa_id)
                    ->update([
                        'status' => 'AF',  // A Faturar
                        'check' => 'P'     // Parcialmente feita
                    ]);
            }
        }
    }
}
