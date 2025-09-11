<?php

namespace App\Models;

use App\Traits\LogTrait;
use App\Traits\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Portaria extends Model
{
    use HasFactory,LogTrait, LogsActivity;


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
        'km',
        'finality',

        'veiculo_tipo',
        'veiculo_nome',
        'veiculo_placa',
        'motorista',
        'rms',
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
        'updated_at',

        'veiculo_tipo',
        'veiculo_nome',
        'veiculo_placa',
        'motorista',
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

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'motorista_id', 'id');
    }

    public function porteiro()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
