<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viabilization extends Model
{
    use HasFactory;

    protected $fillable = [
        'observacoes',
        'responsavel',
        'participantes',
        'escopo_servico',
        'ambiental',
        'ambiental_comentario',
        'seguranca_via',
        'seguranca_comentario',
        'qualidade',
        'qualidade_comentario',
        'elaboracao',
        'elaboracao_comentario',
        'viavel',
        'responsavel_id',
    ];

    protected $table = 'obras_viabilizations';

}
