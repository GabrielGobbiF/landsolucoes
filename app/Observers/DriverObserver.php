<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Driver;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DriverObserver
{
    /**
     * Handle the Driver "creating" event.
     *
     * @param  \App\Models\Driver  $driver
     * @return void
     */
    public function creating(Driver $driver)
    {
        $driver->name = titleCase($driver->name);
        $driver->cnh_category = mb_strtoupper($driver->cnh_category);
        $driver->cpf = clear($driver->cpf);
    }

    /**
     * Handle the plan "updating" event.
     *
     * @param  \App\Models\Driver  $driver
     * @return void
     */
    public function updating(Driver $driver)
    {
        $driver->name = titleCase($driver->name);
        $driver->cnh_category = mb_strtoupper($driver->cnh_category);
        $driver->cpf = clear($driver->cpf);
    }
}
