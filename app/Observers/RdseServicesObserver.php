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

        $rdseServices->p_preco1 = !empty($rdseServices->p_preco1) ? clearNumber($rdseServices->p_preco1) : 0;
        $rdseServices->p_preco2 = !empty($rdseServices->p_preco2) ? clearNumber($rdseServices->p_preco2) : 0;
        $rdseServices->p_preco3 = !empty($rdseServices->p_preco3) ? clearNumber($rdseServices->p_preco3) : 0;
    }

    /**
     * Handle the plan "updating" event.
     *
     * @param  \App\Models\RdseServices  $rdseServices
     * @return void
     */
    public function updating(RdseServices $rdseServices)
    {
        $rdseServices->p_preco1 = !empty($rdseServices->p_preco1) ? clearNumber($rdseServices->p_preco1) : 0;
        $rdseServices->p_preco2 = !empty($rdseServices->p_preco2) ? clearNumber($rdseServices->p_preco2) : 0;
        $rdseServices->p_preco3 = !empty($rdseServices->p_preco3) ? clearNumber($rdseServices->p_preco3) : 0;
        #$rdseServices->slug = Str::slug(mb_strtolower($rdseServices->name, 'UTF-8'), '_');
    }

    private static function getLastOrder($rdseId)
    {
        $lastId =  RdseServices::withoutGlobalScopes()->where('rdse_id', $rdseId)->orderBy('id', 'DESC')->select('order')->limit(1)->first();

        return !empty($lastId) ? $lastId->order + 1 : 0;
    }
}
