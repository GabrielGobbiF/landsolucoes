<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ObraEtapasFinanceiro extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
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
        $status = DB::select('select * from obras_etapas where id_etapa = ? AND id_obra = ? ', [
            $this->etapa_id,
            $this->obra_id,
        ]);

        $status = $status[0] ?? [];

        if ($status) {
            return [
                'nome' => $status->nome,
                'text'  => $status->check,
                'label' => $this->getStatusLabelAttribute($status->check),
            ];
        } else {
            return [
                'nome' => '',
                'text'  => '',
                'label' => '',
            ];
        }
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
        return EtapasFaturamento::select(DB::raw('sum(valor) as sum, COUNT(id) as qnt, data_vencimento'))
            ->where('obr_etp_financerio_id', $this->id)
            ->where('recebido_status', 'N')
            ->first();

        #DB::select("select sum(valor) as sum, COUNT(id) as qnt, data_vencimento from etapas_faturamentos WHERE obr_etp_financerio_id = ? AND data_vencimento <= DATE(NOW()) AND recebido_status = 'N'", [$this->id]);
        #return dd($this->faturamento->where(DB::raw('data_vencimento < DATE_ADD(DATE_ADD(LAST_DAY(CURRENT_DATE), INTERVAL 1 DAY), INTERVAL 1 MONTH)'))->sum('valor'));
    }

    public function vencidas()
    {
        return EtapasFaturamento::select(DB::raw('sum(valor) as sum, COUNT(id) as qnt, data_vencimento'))
            ->where('obr_etp_financerio_id', $this->id)
            ->where('recebido_status', 'N')
            ->whereDate('data_vencimento', '<=', date('Y-m-d'))->first();
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
