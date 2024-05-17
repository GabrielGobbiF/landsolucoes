<?php

namespace App\Listeners\Frotas\Visitor;

use App\Events\Frotas\Visitor\VisitorStatusChange;
use App\Models\User;
use App\Supports\Enums\Frota\VisitorsStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleVisitorStatusChange implements ShouldQueue
{
    use InteractsWithQueue;

    public $afterCommit = true;

    private $visitor, $userAdmin, $userEvent;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(VisitorStatusChange $event): void
    {
        $this->visitor = $event->visitor;

        match ($event->status) {
            #VisitorsStatus::CREATED => $this->created(),
            VisitorsStatus::RELEASED => $this->released(),
            VisitorsStatus::CLOSED => $this->closed(),
            default => null
        };
    }

    private function released()
    {
        $this->visitor->setLog('released');

    }

    private function closed()
    {
        $this->visitor->setLog('closed');
    }
}
