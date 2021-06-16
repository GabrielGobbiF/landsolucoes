<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\ObraFinanceiro;
use Carbon\Carbon;
use \NumberFormatter;

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
        $valor_custo = str_replace(['R$', '&nbsp', chr(194) . chr(160)], '', $obraFinanceiro->valor_custo);
        $obraFinanceiro->valor_custo = $valor_custo != '' ? number_format(str_replace(",",".",str_replace(".","",$valor_custo)), 2, '.', '') : '0.00';

        $valor_proposta = str_replace(['R$', '&nbsp', chr(194) . chr(160)], '', $obraFinanceiro->valor_proposta);
        $obraFinanceiro->valor_proposta = $valor_proposta != '' ? number_format(str_replace(",",".",str_replace(".","",$valor_proposta)), 2, '.', '') : '0.00';

        $valor_desconto = str_replace(['R$', '&nbsp', chr(194) . chr(160)], '', $obraFinanceiro->valor_desconto);
        $obraFinanceiro->valor_desconto = $valor_desconto != '' ? number_format(str_replace(",",".",str_replace(".","",$valor_desconto)), 2, '.', '') : '0.00';

        $valor_negociado = str_replace(['R$', '&nbsp', chr(194) . chr(160)], '', $obraFinanceiro->valor_negociado);
        $obraFinanceiro->valor_negociado = $valor_negociado != '' ? number_format(str_replace(",",".",str_replace(".","",$valor_negociado)), 2, '.', '') : '0.00';

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

        $valor_custo = str_replace(['R$', '&nbsp', chr(194) . chr(160)], '', $obraFinanceiro->valor_custo);
        $obraFinanceiro->valor_custo = $valor_custo != '' ? number_format(str_replace(",",".",str_replace(".","",$valor_custo)), 2, '.', '') : '0.00';

        $valor_proposta = str_replace(['R$', '&nbsp', chr(194) . chr(160)], '', $obraFinanceiro->valor_proposta);
        $obraFinanceiro->valor_proposta = $valor_proposta != '' ? number_format(str_replace(",",".",str_replace(".","",$valor_proposta)), 2, '.', '') : '0.00';

        $valor_desconto = str_replace(['R$', '&nbsp', chr(194) . chr(160)], '', $obraFinanceiro->valor_desconto);
        $obraFinanceiro->valor_desconto = $valor_desconto != '' ? number_format(str_replace(",",".",str_replace(".","",$valor_desconto)), 2, '.', '') : '0.00';

        $valor_negociado = str_replace(['R$', '&nbsp', chr(194) . chr(160)], '', $obraFinanceiro->valor_negociado);
        $obraFinanceiro->valor_negociado = $valor_negociado != '' ? number_format(str_replace(",",".",str_replace(".","",$valor_negociado)), 2, '.', '') : '0.00';

        $obraFinanceiro->envio_at = Carbon::parse(str_replace('/', '-', $obraFinanceiro->envio_at))->format('Y-m-d');
    }
}
