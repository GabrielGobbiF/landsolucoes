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
        return LogOptions::defaults()
            ->logOnly($this->getFillable())
            ->logOnlyDirty()
            ->useLogName(singular($this->getTable()))
            ->setDescriptionForEvent(fn(string $eventName) => "logs.events.badge.{$eventName}")
            ->dontSubmitEmptyLogs();
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
