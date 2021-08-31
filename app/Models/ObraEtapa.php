<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObraEtapa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_obra',
        'id_etapa',
        'tipo_id',
        'nome',
        'check',
        'status',
        'ordem',
        'nota_numero',
        'responsavel',
        'cliente_responsavel',
        'preco',
        'quantidade',
        'unidade',
        'observacao',
        'observacao_sistema',
        'prazo_atendimento',
        'tempo_atividade',
        'data_abertura',
        'data_programada',
        'data_iniciada',
        'data_prazo_total',
        'meta_etapa',
        'data_pedido'
    ];

    protected $table = 'obras_etapas';

    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }

    public function variables()
    {
        return $this->hasMany(ObraEtapasVariables::class, 'etapa_id', 'id');
    }

    public function financeiro()
    {
        return $this->hasMany(ObraEtapasFinanceiro::class, 'etapa_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'etapa_id', 'id');
    }
}
