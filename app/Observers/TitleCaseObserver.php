<?php

namespace App\Observers;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class TitleCaseObserver
{
    /**
     * Handle the plan "creating" event.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function creating(Model $model)
    {
        $model->name = titleCase($model->name);
    }
}
