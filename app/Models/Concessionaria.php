<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concessionaria extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class, 'concessionaria_id');
    }

    public function etapas($service_id)
    {
        return $this->belongsToMany(Etapa::class, 'con_service_etp', 'concessionaria_id')->where(['service_id' => $service_id])->withPivot(['order']);
    }
}
