<?php

namespace App\Listeners;

use Illuminate\Cache\Events\CacheCleared;

class ResetReloadFlagListener
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Cache\Events\CacheCleared  $event
     * @return void
     */
    public function handle(CacheCleared $event)
    {
        // Redefine a flag resetReloadFlag para o estado inicial
        cache()->put('resetReloadFlag', false, now()->addDay());
    }
}
