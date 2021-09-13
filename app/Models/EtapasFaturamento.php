<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtapasFaturamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'coluna_faturamento',
        'nf_n',
        'data_emissao',
        'data_vencimento',
        'valor',
        'recebido_status',
        'status',
    ];
}
