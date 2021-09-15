<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    protected $appends = ['StatusEtapa'];

    public function getStatusEtapaAttribute()
    {
        $status = $this->etapa;

        if ($status) {
            return [
                'text'  => $status->check,
                'label' => $this->getStatusLabelAttribute($status->check),
            ];
        }
    }

    public function etapa()
    {
        return $this->belongsTo(ObraEtapa::class, 'etapa_id', 'id');
    }

    public function faturamento()
    {
        return $this->hasMany(EtapasFaturamento::class, 'obr_etp_financerio_id', 'id');
    }

    public function aFaturar()
    {
    }

    public function aReceber()
    {
        $dia_atual = date("d");
        return DB::select("select sum(valor) as sum from etapas_faturamentos WHERE obr_etp_financerio_id = ? AND data_vencimento <= DATE(NOW())", [$this->id]);
        #return dd($this->faturamento->where(DB::raw('data_vencimento < DATE_ADD(DATE_ADD(LAST_DAY(CURRENT_DATE), INTERVAL 1 DAY), INTERVAL 1 MONTH)'))->sum('valor'));
    }

    public function faturado()
    {
        return $this->faturamento->sum('valor');
    }

    public function recebido()
    {
        return $this->faturamento->where('recebido_status', 'Y')->sum('valor');
    }

    public function getStatusLabelAttribute($status)
    {
        switch ($status) {
            case 'EM':
                $label = 'warning';
                break;
            case 'C':
            case 'campaign_started':
                $label = 'success';
                break;
            default:
                $label = 'info';
                break;
        }

        return $label;
    }
}
