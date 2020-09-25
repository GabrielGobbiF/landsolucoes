<?php

namespace App\Providers;

use App\Models\Employees;
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
            $model->uuid = Str::uuid();
        });
    }
}
