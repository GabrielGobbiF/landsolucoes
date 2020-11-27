<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Vehicle extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
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
    ];

    protected static $logAttributes = [
        'name',
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
    ];

    protected static $logName = 'Vehicles';
}
