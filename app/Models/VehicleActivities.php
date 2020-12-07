<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class VehicleActivities extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'title',
        'description',
        'km_start',
        'km_end',
        'driver_name',
        'driver_id',
        'observation',
        'nota_fiscal'
    ];

    protected $hidden = [
        'id',
    ];

    protected static $logAttributes = [
        'id',
        'title',
        'description',
        'km_start',
        'km_end',
        'driver_name',
        'driver_id',
        'vehicle_id',
        'observation',
        'created_at',
        'updated_at',
        'nota_fiscal'
    ];

    protected static $logName = 'VehicleActivities';

    public function Vehicle()
    {
        //return $this->hasMany(Auditory::class, 'employee_id', 'id');
    }
}
