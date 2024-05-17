<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Pasta;

class PastaObserver
{
    /**
     * Handle the Pasta "creating" event.
     *
     * @param  \App\Models\Pasta  $pasta
     * @return void
     */
    public function creating(Pasta $pasta)
    {
        $pasta->uuid = uniqid(((date('s') / 12) * 24) + mt_rand(800, 9999));
        $pasta->name = titleCase(mb_strtolower($pasta->name, 'UTF-8'));
        $pasta->slug = Str::slug(mb_strtolower($pasta->name, 'UTF-8'), '_');
        $pasta->url =  $pasta->url . '/' . $pasta->uuid;
    }

    /**
     * Handle the plan "updating" event.
     *
     * @param  \App\Models\Pasta  $pasta
     * @return void
     */
    public function updating(Pasta $pasta)
    {
        $pasta->slug = Str::slug(mb_strtolower($pasta->name, 'UTF-8'), '_');
        $pasta->name = titleCase(mb_strtolower($pasta->name, 'UTF-8'));
        $pasta->url =  $pasta->url . '/' . $pasta->uuid;
    }
}
