<?php

namespace App\Observers;

use App\Models\ObraFinanceiro;
use Carbon\Carbon;

class ObraFinanceiroObserver
{
    /**
     * Handle the ObraFinanceiro "creating" event.
     *
     * @param  \App\Models\ObraFinanceiro  $obraFinanceiro
     * @return void
     */
    public function creating(ObraFinanceiro $obraFinanceiro)
    {
        $obraFinanceiro->valor_custo = clearNumber($obraFinanceiro->valor_custo);
        $obraFinanceiro->valor_proposta = clearNumber($obraFinanceiro->valor_proposta);
        $obraFinanceiro->valor_desconto = clearNumber($obraFinanceiro->valor_desconto);
        $obraFinanceiro->valor_negociado = clearNumber($obraFinanceiro->valor_negociado);

        $obraFinanceiro->envio_at = Carbon::parse(str_replace('/', '-', $obraFinanceiro->envio_at))->format('Y-m-d');
    }

    /**
     * Handle the plan "updating" event.
     *
     * @param  \App\Models\ObraFinanceiro  $obraFinanceiro
     * @return void
     */
    public function updating(ObraFinanceiro $obraFinanceiro)
    {
        $obraFinanceiro->valor_custo = clearNumber($obraFinanceiro->valor_custo);
        $obraFinanceiro->valor_proposta = clearNumber($obraFinanceiro->valor_proposta);
        $obraFinanceiro->valor_desconto = clearNumber($obraFinanceiro->valor_desconto);
        $obraFinanceiro->valor_negociado = clearNumber($obraFinanceiro->valor_negociado);

        $obraFinanceiro->envio_at = Carbon::parse(str_replace('/', '-', $obraFinanceiro->envio_at))->format('Y-m-d');
    }
}
