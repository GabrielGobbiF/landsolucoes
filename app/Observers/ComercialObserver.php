<?php

namespace App\Observers;

use App\Events\Comercial\ComercialStatusChange;
use Illuminate\Support\Str;
use App\Models\Obra;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ComercialObserver
{
    /**
     * Handle the Obra "creating" event.
     *
     * @param  \App\Models\Obra  $obra
     * @return void
     */
    public function creating(Obra $obra)
    {
        $date = str_replace('/', '-', $obra->build_at);
        $obra->build_at = Carbon::parse($date)->format('Y-m-d');
    }

    /**
     * Handle the plan "updating" event.
     *
     * @param  \App\Models\Obra  $obra
     * @return void
     */
    public function updating(Obra $obra)
    {
        $date = str_replace('/', '-', $obra->build_at);
        $obra->build_at = Carbon::parse($date)->format('Y-m-d');

    }

    public function saved(Obra $comercial)
    {
        if ($comercial->wasChanged('status')) {
            ComercialStatusChange::dispatch($comercial, $comercial->status, auth()->user());
        }
    }
}
