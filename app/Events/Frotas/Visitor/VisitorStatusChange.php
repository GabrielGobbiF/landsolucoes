<?php

namespace App\Events\Frotas\Visitor;

use App\Models\Visitor;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VisitorStatusChange
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Evento Registrado em
     * @var \App\Listeners\Frotas\Visitor\HandleVisitorStatusChange
     */
    public function __construct(public Visitor $visitor, public $status)
    {
    }
}
