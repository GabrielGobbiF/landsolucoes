<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Etapa;

class EtapaObserver
{
    /**
     * Handle the Etapa "creating" event.
     *
     * @param  \App\Models\Etapa  $etapa
     * @return void
     */
    public function creating(Etapa $etapa)
    {
        $etapa->slug = Str::slug(mb_strtolower($etapa->name, 'UTF-8'), '_');
        $etapa->preco = str_replace(['.', ',', '/', '-'], '', $etapa->preco);
    }

    /**
     * Handle the plan "updating" event.
     *
     * @param  \App\Models\Etapa  $etapa
     * @return void
     */
    public function updating(Etapa $etapa)
    {
        $etapa->slug = Str::slug(mb_strtolower($etapa->name, 'UTF-8'), '_');
        $etapa->preco = str_replace(['.', ',', '/', '-'], '', $etapa->preco);
    }
}
