<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Portaria extends Model
{
    use HasFactory, LogsActivity;

    protected static $logName = 'Portaria';

    protected $table = 'portarias';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'motorista_id',
        'vehicle_id',
        'observations',
        'files',
        'type',
        'controlador',
        'departamento',
        'km'
    ];

    protected static $logAttributes = [
        'id',
        'user_id',
        'motorista_id',
        'vehicle_id',
        'observations',
        'files',
        'type',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    public function veiculo()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

    public function motorista()
    {
        return $this->belongsTo(User::class, 'motorista_id', 'id');
    }

    public function porteiro()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
