<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Service;

class ServiceObserver
{
    /**
     * Handle the Service "creating" event.
     *
     * @param  \App\Models\Service  $service
     * @return void
     */
    public function creating(Service $service)
    {
        $slug = Str::slug(mb_strtolower($service->name, 'UTF-8'), '_');
        $service->slug = $slug;
    }

    /**
     * Handle the plan "updating" event.
     *
     * @param  \App\Models\Service  $service
     * @return void
     */
    public function updating(Service $service)
    {
        $slug = Str::slug(mb_strtolower($service->name, 'UTF-8'), '_');
        $service->slug = $slug;
    }
}
