<?php

namespace App\Listeners\Comercial;

use App\Events\Comercial\ComercialStatusChange;
use App\Models\User;
use App\Supports\Enums\Comercial\ComercialStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleComercialStatusChange implements ShouldQueue
{
    use InteractsWithQueue;

    public $afterCommit = true;

    private $comercial, $userAdmin, $userEvent;

    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(ComercialStatusChange $event): void
    {
        $this->comercial = $event->comercial;

        match ($event->status) {
            ComercialStatus::ELABORACAO => $this->comercialElaboracao(),
            ComercialStatus::ENVIADA => $this->comercialEnviada(),
            ComercialStatus::APROVADA => $this->comercialAprovada(),
            ComercialStatus::RECUSADA => $this->comercialRecusada(),
            ComercialStatus::CONCLUIDA => $this->comercialConcluida(),

            default => null
        };
    }

    private function comercialElaboracao()
    {
        $this->comercial->setLog('elaboracao');
    }

    private function comercialEnviada()
    {
        $this->comercial->setLog('enviada');
    }

    private function comercialAprovada()
    {
        $this->comercial->setLog('aprovada');
    }

    private function comercialRecusada()
    {
        $this->comercial->setLog('recusada');
    }

    private function comercialConcluida()
    {
        $this->comercial->setLog('concluida');
    }
}
