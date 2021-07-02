<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Obra extends Model
{
    use HasFactory, SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_id',
        'client_id',
        'concessionaria_id',
        'address_id',
        'viabilization_id',
        'department_id',
        'razao_social',
        'description',
        'last_note',
        'cnpj',
        'razao_social_obra_cliente',
        'obr_informacoes',
        'status',
        'obr_urgence',
        'build_at',
    ];

    protected $dates = ['deleted_at'];

    public function departments()
    {
        return $this->belongsTo(Department::class, 'client_id');
    }

    public function UserFavorites()
    {
        return $this->morphToMany(User::class, 'favoritable');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function concessionaria()
    {
        return $this->belongsTo(Concessionaria::class, 'concessionaria_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function andress()
    {
        return $this->belongsTo(Andress::class, 'address_id');
    }

    public function viabilizacao()
    {
        return $this->belongsTo(Viabilization::class, 'viabilization_id');
    }

    public function financeiro()
    {
        return $this->hasOne(ObraFinanceiro::class, 'id_obra');
    }

    public function etapas()
    {
        return $this->hasMany(ObraEtapa::class, 'id_obra');
    }

    public function etapas_financeiro()
    {
        return $this->hasMany(ObraEtapasFinanceiro::class, 'obra_id');
    }
}
