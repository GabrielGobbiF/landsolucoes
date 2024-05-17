<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObraEtapasVariables extends Model
{
    use HasFactory;

    protected $fillable = [
        'etapa_id',
        'obra_id',
        'nome',
        'preco',
        'quantidade',
    ];

    protected $table = 'obras_etapas_variables';

}
