<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\RSDE\RdseServices;

class RdseServicesObserver
{
    /**
     * Handle the RdseServices "creating" event.
     *
     * @param  \App\Models\RdseServices  $rdseServices
     * @return void
     */
    public function creating(RdseServices $rdseServices)
    {
        $rdseServices->order = $this->getLastOrder($rdseServices->rdse_id);
    }

    /**
     * Handle the plan "updating" event.
     *
     * @param  \App\Models\RdseServices  $rdseServices
     * @return void
     */
    public function updating(RdseServices $rdseServices)
    {
        #$rdseServices->slug = Str::slug(mb_strtolower($rdseServices->name, 'UTF-8'), '_');
    }

    private static function getLastOrder($rdseId)
    {
        $lastId =  RdseServices::withoutGlobalScopes()->where('rdse_id', $rdseId)->orderBy('id', 'DESC')->select('order')->limit(1)->first();

        return !empty($lastId) ? $lastId->order + 1 : 0;
    }
}
