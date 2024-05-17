<?php

namespace App\Observers;

use App\Events\Frotas\Visitor\VisitorStatusChange;
use Illuminate\Support\Str;
use App\Models\Visitor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class VisitorObserver
{
    /**
     * Handle the Visitor "creating" event.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return void
     */
    public function creating(Visitor $visitor)
    {
        $visitor->user_id = auth()->user()->id;
    }

    /**
     * Handle the plan "updating" event.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return void
     */
    public function updating(Visitor $visitor)
    {
    }

    /**
     * Handle the Visitor "updated" event.
     *
     * @param  \App\Models\Visitor  $Visitor
     * @return void
     */
    public function updated(Visitor $visitor)
    {
        if ($visitor->isDirty('status')) {
            VisitorStatusChange::dispatch($visitor, $visitor->status);
        }
    }
}
