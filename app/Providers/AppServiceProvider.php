<?php

namespace App\Providers;

use App\Models\Employees;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Employees::creating(function ($model) {
            $user = Auth::user();
            $model->uuid = Str::uuid();
            $model->created_by = $user->id;
        });

        Employees::updating(function ($model) {
            $user = Auth::user();
            $model->updated_by = $user->id;
        });

    }
}
