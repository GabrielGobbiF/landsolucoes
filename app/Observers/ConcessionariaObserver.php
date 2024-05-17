<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Concessionaria;

class ConcessionariaObserver
{
    /**
     * Handle the Concessionaria "creating" event.
     *
     * @param  \App\Models\Concessionaria  $concessionaria
     * @return void
     */
    public function creating(Concessionaria $concessionaria)
    {
        $concessionaria->slug = Str::slug(mb_strtolower($concessionaria->name, 'UTF-8'), '_');

    }

    /**
     * Handle the plan "updating" event.
     *
     * @param  \App\Models\Concessionaria  $concessionaria
     * @return void
     */
    public function updating(Concessionaria $concessionaria)
    {
        $concessionaria->slug = Str::slug(mb_strtolower($concessionaria->name, 'UTF-8'), '_');
    }
}
