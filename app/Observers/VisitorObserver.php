<?php

namespace App\Observers;

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
}
