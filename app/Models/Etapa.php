<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_id',
        'name',
        'slug',
        'descricao',
        'quantidade',
        'preco',
        'unidade',
        'categoria',
        'sub_categoria',
    ];

    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }

    public function setPrecoAttribute($value)
    {
        $this->attributes['preco'] = clearNumber($value);
    }

    public function concessionaria()
    {
        return $this->belongsToMany(Concessionaria::class, 'con_service_etp', 'etapa_id');
    }

    public function variables()
    {
        return $this->hasMany(Variable::class, 'etapa_id');
    }
}
