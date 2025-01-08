<?php

namespace App\Providers;

use App\Events\Comercial\ComercialStatusChange;
use App\Events\Frotas\Visitor\VisitorStatusChange;
use App\Listeners\Comercial\HandleComercialStatusChange;
use App\Listeners\Frotas\Visitor\HandleVisitorStatusChange;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        VisitorStatusChange::class => [
            HandleVisitorStatusChange::class,
        ],

        ComercialStatusChange::class => [
            HandleComercialStatusChange::class,
        ],

        \Illuminate\Cache\Events\CacheCleared::class => [
            \App\Listeners\ResetReloadFlagListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
