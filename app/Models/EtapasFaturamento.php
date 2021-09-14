<?php

namespace App\Models;

use Carbon\Carbon;
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

    protected $casts = [
        'data_vencimento'  => 'datetime:Y-m-d H:i:s',
        'data_emissao' => 'datetime:Y-m-d H:i:s',
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    public function setDataVencimentoAttribute($value)
    {
        $this->attributes['data_vencimento'] = Carbon::parse(str_replace('/', '-', $value))->format('Y-m-d H:i:s');
    }

    public function setDataEmissaoAttribute($value)
    {
        $this->attributes['data_emissao'] = Carbon::parse(str_replace('/', '-', $value))->format('Y-m-d H:i:s');
    }

    public function setValorAttribute($value)
    {
        $this->attributes['valor'] = clearNumber($value);
    }
}
