<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Documento;

class DocumentoObserver
{
    /**
     * Handle the Documento "creating" event.
     *
     * @param  \App\Models\Documento  $documento
     * @return void
     */
    public function creating(Documento $documento)
    {
        $documento->uuid = uniqid(((date('s') / 12) * 24) + mt_rand(800, 9999));

        $documento->name = mb_strtolower($documento->name, 'UTF-8');

    }

    /**
     * Handle the plan "updating" event.
     *
     * @param  \App\Models\Documento  $documento
     * @return void
     */
    public function updating(Documento $documento)
    {
        $documento->name = mb_strtolower($documento->name, 'UTF-8');

    }
}
