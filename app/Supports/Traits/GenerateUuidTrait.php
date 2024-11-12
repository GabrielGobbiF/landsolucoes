<?php

declare(strict_types=1);

namespace App\Supports\Traits;

use Illuminate\Support\Str;

trait GenerateUuidTrait
{
    public static function bootGenerateUuidTrait(): void
    {
        static::saving(function ($model) {
            $model->uuid = uuid();
        });
    }
}
