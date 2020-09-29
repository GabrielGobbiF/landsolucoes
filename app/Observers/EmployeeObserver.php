<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Employees;
use Illuminate\Support\Facades\Auth;

class EmployeeObserver
{
    /**
     * Handle the Employees "creating" event.
     *
     * @param  \App\Models\Employees  $employee
     * @return void
     */
    public function creating(Employees $employee)
    {
        $user = Auth::user();
        $employee->created_at = $user->id;
    }

    /**
     * Handle the Employees "updated" event.
     *
     * @param  \App\Models\Employees  $employee
     * @return void
     */
    public function updating(Employees $employee)
    {
        $user = Auth::user();
        $employee->updated_by = $user->id;
    }
}
