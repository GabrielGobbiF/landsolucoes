<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

trait LogTrait
{
    public function getActivitylogOptions(): LogOptions
    {
        $fillable = $this->getFilteredFillable();

        $options = LogOptions::defaults()
            ->logOnly($fillable)
            ->logOnlyDirty()
            ->useLogName(singular($this->getTable()))
            ->setDescriptionForEvent(fn(string $eventName) => "logs.events.badge.{$eventName}")
            ->dontSubmitEmptyLogs();

        if (method_exists($this, 'customizeLogOptions')) {
            $options = $this->customizeLogOptions($options);
        }

        return $options;
    }

    private function getFilteredFillable(): array
    {
        $fillable = $this->getFillable();

        if (property_exists($this, 'ignoreChangedAttributes') && is_array(static::$ignoreChangedAttributes)) {
            $fillable = array_diff($fillable, static::$ignoreChangedAttributes);
        }

        return $fillable;
    }


    public function logs()
    {
        return Activity::forSubject($this)
            ->orderBy('id', 'desc')
            ->paginate();
    }

    public function setLog(string $message, User $user = null): void
    {
        _log(
            singular($this->getTable()),
            $this,
            $user ? $user : auth()->user()->id,
            $this->getTable() . ".log.badge.$message",
            [
                'routes' => [
                    'admin' => config('app.url') . request()->getPathInfo(),
                    #'web' => $routeWeb
                ],
                'observations' => $message['observations'] ?? null,
            ]
        );
    }
}
