<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class EmployeeObserver
{
    public function __construct()
    {
    }
    /**
     * Handle the Employee "creating" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function creating(Employee $employee)
    {
        $user = Auth::user();

        $employee->uuid = Str::uuid();
        $employee->created_by = $user->id;
    }

}
