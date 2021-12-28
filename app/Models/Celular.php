<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Celular extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario',
        'responsavel',
        'equipe',
        'linha',
        'departamento',
        'centro_custo',
    ];

    protected $table = 'celulares';

    public function setLinhaAttribute($value)
    {
        $this->attributes['linha'] = limpar($value, '');
    }

}
