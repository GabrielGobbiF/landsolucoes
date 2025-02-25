<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\ObraEtapa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ObraEtapaObserver
{
    /**
     * Handle the ObraEtapa "creating" event.
     *
     * @param  \App\Models\ObraEtapa  $obraEtapa
     * @return void
     */
    public function creating(ObraEtapa $obraEtapa)
    {
        #$obraEtapa->data_abertura = $obraEtapa->data_abertura != '' ? Carbon::parse(str_replace('/', '-', $obraEtapa->data_abertura))->format('Y-m-d') : null;
        #$obraEtapa->meta_etapa = $obraEtapa->meta_etapa != '' ? Carbon::parse(str_replace('/', '-', $obraEtapa->meta_etapa))->format('Y-m-d') : null;
        #$obraEtapa->data_programada = $obraEtapa->data_programada != '' ? Carbon::parse(str_replace('/', '-', $obraEtapa->data_programada))->format('Y-m-d') : null;
        #$obraEtapa->data_iniciada = $obraEtapa->data_iniciada != '' ? Carbon::parse(str_replace('/', '-', $obraEtapa->data_iniciada))->format('Y-m-d') : null;
        #$obraEtapa->data_prazo_total = $obraEtapa->data_prazo_total != '' ? Carbon::parse(str_replace('/', '-', $obraEtapa->data_prazo_total))->format('Y-m-d') : null;
        #$obraEtapa->data_pedido = $obraEtapa->data_pedido != '' ? Carbon::parse(str_replace('/', '-', $obraEtapa->data_pedido))->format('Y-m-d') : null;

    }

    /**
     * Handle the plan "updating" event.
     *
     * @param  \App\Models\ObraEtapa  $obraEtapa
     * @return void
     */
    public function updating(ObraEtapa $obraEtapa)
    {
        $data_abertura = Carbon::parse(str_replace('/', '-', $obraEtapa->data_abertura));
        $prazo_atendimento = intVal($obraEtapa->prazo_atendimento);
        $data_prazo_total = $data_abertura->addDays($prazo_atendimento);
        $obraEtapa->data_prazo_total = $data_prazo_total;

        #$obraEtapa->data_abertura = $obraEtapa->data_abertura != '' ? Carbon::parse(str_replace('/', '-', $obraEtapa->data_abertura))->format('Y-m-d') : null;
        #$obraEtapa->meta_etapa = $obraEtapa->meta_etapa != '' ? Carbon::parse(str_replace('/', '-', $obraEtapa->meta_etapa))->format('Y-m-d') : null;
        #$obraEtapa->data_programada = $obraEtapa->data_programada != '' ? Carbon::parse(str_replace('/', '-', $obraEtapa->data_programada))->format('Y-m-d') : null;
        #$obraEtapa->data_iniciada = $obraEtapa->data_iniciada != '' ? Carbon::parse(str_replace('/', '-', $obraEtapa->data_iniciada))->format('Y-m-d') : null;
        #$obraEtapa->data_prazo_total = $obraEtapa->data_prazo_total != '' ? Carbon::parse(str_replace('/', '-', $obraEtapa->data_prazo_total))->format('Y-m-d') : null;
        #$obraEtapa->data_pedido = $obraEtapa->data_pedido != '' ? Carbon::parse(str_replace('/', '-', $obraEtapa->data_pedido))->format('Y-m-d') : null;
    }
}
