<?php

namespace App\Observers;

use App\Models\RSDE\Handswork;
use Illuminate\Support\Str;

class HandworkObserver
{
    /**
     * Handle the Handswork "creating" event.
     *
     * @param  \App\Models\Handswork  $handswork
     * @return void
     */
    public function creating(Handswork $handswork)
    {
        $handswork->price_ups = !empty($handswork->price_ups) ? clearNumber($handswork->price_ups) : 0;
        $handswork->price = !empty($handswork->price) ? clearNumber($handswork->price) : 0;
        $handswork->description = !empty($handswork->description) ? mb_strtoupper($handswork->description, 'UTF-8') : '';
    }

    /**
     * Handle the plan "updating" event.
     *
     * @param  \App\Models\Handswork  $handswork
     * @return void
     */
    public function updating(Handswork $handswork)
    {
        $handswork->price_ups = !empty($handswork->price_ups) ? clearNumber($handswork->price_ups) : 0;
        $handswork->price = !empty($handswork->price) ? clearNumber($handswork->price) : 0;
        $handswork->description = !empty($handswork->description) ? mb_strtoupper($handswork->description, 'UTF-8') : '';
    }
}
