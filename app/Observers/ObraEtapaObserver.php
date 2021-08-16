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
        $obraEtapa->data_abertura = $obraEtapa->data_abertura != '' ? Carbon::parse(str_replace('/', '-', $obraEtapa->data_abertura))->format('Y-m-d') : null;
        $obraEtapa->meta_etapa = $obraEtapa->meta_etapa != '' ? Carbon::parse(str_replace('/', '-', $obraEtapa->meta_etapa))->format('Y-m-d') : null;
    }

    /**
     * Handle the plan "updating" event.
     *
     * @param  \App\Models\ObraEtapa  $obraEtapa
     * @return void
     */
    public function updating(ObraEtapa $obraEtapa)
    {
        $obraEtapa->data_abertura = $obraEtapa->data_abertura != '' ? Carbon::parse(str_replace('/', '-', $obraEtapa->data_abertura))->format('Y-m-d') : null;
        $obraEtapa->meta_etapa = $obraEtapa->meta_etapa != '' ? Carbon::parse(str_replace('/', '-', $obraEtapa->meta_etapa))->format('Y-m-d') : null;
    }
}
