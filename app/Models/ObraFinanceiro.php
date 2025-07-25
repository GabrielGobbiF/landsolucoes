<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObraFinanceiro extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_obra',
        'valor_proposta',
        'valor_negociado',
        'valor_desconto',
        'valor_custo',
        'metodo_pagamento',
        'envio_at',
        'faturado',
        'total_a_faturar',
        'recebido',
        'a_receber',
        'vencidas',
        'saldo',
    ];

    protected $table = 'obras_financeiro';
}
