<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObraEtapasFinanceiro extends Model
{
    use HasFactory;

    protected $fillable = [
        'etapa_id',
        'obra_id',
        'metodo_pagamento',
        'valor',
        'valor_receber',
        'nome_etapa'
    ];

    protected $table = 'obras_etapas_financeiro';

}
