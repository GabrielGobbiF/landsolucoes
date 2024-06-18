<?php

namespace App\Events\Comercial;

use App\Models\Obra;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ComercialStatusChange
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Evento Registrado em
     * @var \App\Listeners\Comercial\HandleComercialStatusChange
     */
    public function __construct(public Obra $comercial, public $status)
    {
    }
}
