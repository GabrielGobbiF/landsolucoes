<?php

namespace App\Models;

use App\Casts\Date;
use App\Casts\OnlyNumber;
use App\Services\Etapas\FinanceiroService;
use App\Supports\Traits\LogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ObraEtapa extends Model
{
    use HasFactory, LogTrait, LogsActivity;

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

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'data_abertura' => Date::class,
        'meta_etapa' => Date::class,
        'data_programada' => Date::class,
        'data_iniciada' => Date::class,
        'data_pedido' => Date::class,
        'data_prazo_total' => Date::class,
        'prazo_atendimento' => OnlyNumber::class,
    ];

    protected $table = 'obras_etapas';

    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }

    public function obra()
    {
        return $this->belongsTo(Obra::class, 'id_obra', 'id');
    }

    public function etapa()
    {
        return $this->belongsTo(Etapa::class, 'id_etapa');
    }

    public function variables()
    {
        return $this->hasMany(ObraEtapasVariables::class, 'etapa_id', 'id');
    }

    public function files()
    {
        return $this->morphMany(Uploaded::class, 'parentable');
    }

    public function financeiro()
    {
        return $this->hasMany(ObraEtapasFinanceiro::class, 'etapa_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'etapa_id', 'id');
    }

    public function etapaFinanceiro($obra_id)
    {
        $etapa_faturamento = ObraEtapasFinanceiro::where('etapa_id', $this->id_etapa)
            ->where('obra_id', $obra_id)
            ->with('faturamento')
            ->first();

        if ($etapa_faturamento) {

            $r = $etapa_faturamento->aReceber();
            $d = $etapa_faturamento->vencidas();

            $etapa = $etapa_faturamento->StatusEtapa;

            $valor_etapa = $etapa_faturamento->valor_receber;

            $etapaFaturado = $etapa_faturamento->faturado();
            $etapaRecebido = $etapa_faturamento->recebido();
            $qntVencidas = $d->qnt;
            $dataVencimento = $r->data_vencimento;
            $totalAReceber = $r->sum;

            $ary =  [
                'id' => $etapa_faturamento->id,
                'nome_etapa' => $etapa['nome'],
                'valor_etapa' => $valor_etapa,
                'total_faturado' => $etapaFaturado,
                'total_a_faturar' => $valor_etapa != '0' ? 'R$ ' . maskPrice($valor_etapa - $etapaFaturado) : '0',
                'qnt_vencidas' => $qntVencidas,
                'dataVencimento' => $dataVencimento,
                'total_receber' => $totalAReceber,
                'status' => $etapa['text'],
                'label' => $etapa['label'],
                'recebido' => $etapaRecebido,
            ];

            if ($ary['total_faturado'] != '0' && $ary['total_faturado'] == $ary['valor_etapa']) {
                if ($ary['total_receber'] != 0) {

                    if ($ary['dataVencimento'] <= date('Y-m-d')) {
                        $state = 'Receber';
                    } else {
                        $state = 'Faturado';
                    }
                } else {
                    $state = 'Recebido';
                }
            } else {
                $state = __('etapa.status.' . $ary['status']);
            }

            $ary['state'] =  "<div class='badge badge-soft-" . $etapa['label'] . "'>" . $state . "</div>";

            return $ary;
        }

        return null;
    }

    public function scopeObraActive($query)
    {
        return $query->whereHas('obra', function ($query) {
            $query->Active();
        });
    }

    protected static function booted()
    {
        static::saved(function ($etapa) {
            $etapa->obra->touch(); // Atualiza o `updated_at` da obra
        });

        static::updating(function ($etapa) {
            if ($etapa->isDirty('check') && $etapa->check === 'C') {
                $user = auth()->user();
                $etapa->setLog(['message' => 'concluido']);
            }
        });

        static::updated(function ($etapa) {
            app(FinanceiroService::class)->saveObraFinanceiro($etapa->obra->id);
        });

        static::deleted(function ($etapa) {
            $etapa->obra->touch(); // Atualiza o `updated_at` da obra
        });
    }
}
