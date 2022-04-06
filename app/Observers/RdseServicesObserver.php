<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Tipo;

class RdseServicesObserver
{
    /**
     * Handle the Tipo "creating" event.
     *
     * @param  \App\Models\Tipo  $tipo
     * @return void
     */
    public function creating(Tipo $tipo)
    {
        #$tipo->slug = Str::slug(mb_strtolower($tipo->name, 'UTF-8'), '_');
    }

    /**
     * Handle the plan "updating" event.
     *
     * @param  \App\Models\Tipo  $tipo
     * @return void
     */
    public function updating(Tipo $tipo)
    {
        #$tipo->slug = Str::slug(mb_strtolower($tipo->name, 'UTF-8'), '_');
    }
}
