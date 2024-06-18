<?php

namespace App\Models;

use App\Traits\LogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class VehicleActivities extends Model
{
    use HasFactory, LogTrait,LogsActivity;

    protected $fillable = [
        'title',
        'description',
        'km_start',
        'km_end',
        'driver_name',
        'driver_id',
        'observation',
        'type',
        'obra_id',
        'obr_razao_social',
        'nota_fiscal',
        'description_return',
        'observation_return',
        'status'
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
        'type',
        'obra_id',
        'obr_razao_social',
        'nota_fiscal',
        'description_return',
        'observation_return',
        'status'
    ];

    protected static $logName = 'VehicleActivities';

    public function Vehicle()
    {
        //return $this->hasMany(Auditory::class, 'employee_id', 'id');
    }
}
