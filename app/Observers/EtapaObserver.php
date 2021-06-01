<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Etapas;

class EtapaObserver
{
    /**
     * Handle the Etapas "creating" event.
     *
     * @param  \App\Models\Etapas  $etapa
     * @return void
     */
    public function creating(Etapas $etapa)
    {
        $etapa->slug = Str::slug(mb_strtolower($etapa->name, 'UTF-8'), '_');

    }

    /**
     * Handle the plan "updating" event.
     *
     * @param  \App\Models\Etapas  $etapa
     * @return void
     */
    public function updating(Etapas $etapa)
    {
        $etapa->slug = Str::slug(mb_strtolower($etapa->name, 'UTF-8'), '_');
    }
}
