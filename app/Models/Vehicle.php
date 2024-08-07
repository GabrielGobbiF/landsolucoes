<?php

namespace App\Models;

use App\Traits\LogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Vehicle extends Model
{
    use HasFactory, LogTrait,LogsActivity;

    protected $fillable = [
        'name',
        'centro_custo',
        'model',
        'board',
        'observation',
        'year',
        'secure',
        'name_company_secure',
        'number_policy',
        'vigency_secure',
        'color',
        'tracker',
        'external_camera',
        'internal_camera',
        'rented',
        'tracker_company',
        'rented_company',
        'qrcode',
        'mtr',
        'chassi',
        'renavam',
        'document_attach',
        'type',
    ];

    protected static $logAttributes = [
        'name',
        'model',
        'centro_custo',
        'board',
        'observation',
        'year',
        'secure',
        'name_company_secure',
        'number_policy',
        'vigency_secure',
        'color',
        'tracker',
        'external_camera',
        'internal_camera',
        'rented',
        'tracker_company',
        'rented_company',
        'qrcode',
        'mtr',
        'chassi',
        'renavam',
        'document_attach',
        'type',
    ];

    protected static $logName = 'Vehicles';

    public function activitys()
    {
        return $this->hasMany(VehicleActivities::class, 'vehicle_id', 'id');
    }
}
