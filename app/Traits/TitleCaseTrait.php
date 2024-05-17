<?php

namespace App\Traits;

use App\Observers\TitleCaseObserver;

trait TitleCaseTrait
{
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = titleCase($value);
    }
}
