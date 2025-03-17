<?php

namespace App\Models\RSDE;

use App\Casts\Date;
use App\Supports\Enums\Rdse\RdseClosingStatus;
use App\Traits\LogTrait;
use Carbon\Carbon;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Rdse extends Model
{
    use HasFactory, SoftDeletes, LogTrait, LogsActivity, Cachable;

    protected static $logName = 'RDSE';

    protected $with = ['services'];

    #protected static $ignoreChangedAttributes   =  ['observations'];

    #protected static $logAttributesToIgnore  =  ['observations'];

    #protected static $logOnlyDirty = true;getServicesTotal

    #protected static $submitEmptyLogs = false;

    protected static $logAttributes = ['*'];

    protected static $logExceptAttributes  = ['*'];

    protected $appends = ['StatusLabel', 'StatusAPR', 'Month', 'AtividadesDescriptions'];

    public function getStatusAPRAttribute()
    {
        $date = Carbon::parse(formatDateAndTime($this->apr_at, 'Y-m-d'));

        $now = Carbon::now();

        $diffInDays = $date->diffInDays($now);

        if ($diffInDays <= 10) {
            return [
                'status' => 'Em Validação',
                'color' => 'red',
                'badge' => 'info',
            ];
        } elseif ($diffInDays > 10 && $diffInDays <= 45) {
            return [
                'status' => 'Aprovada',
                'badge' => 'success',
                'color' => 'success',
            ];
        } else {
            return [
                'status' => 'Vencida',
                'badge' => 'danger',
                'color' => 'danger',
            ];
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'n_order',
        'equipe',
        'solicitante',
        'at',
        'type',
        'modelo',
        'obra_id',
        'lote',
        'observations',
        'diretoria',
        'nf',
        'date_nfe_at',
        'croqui_atualizado_data',
        'croqui_atualizado_responsavel',
        'croqui_validado_data',
        'croqui_validado_responsavel',
        'croqui_finalizado_data',
        'croqui_finalizado_responsavel',

        'observations_execution',
        'observations_viabilidade',
        'observations_programacao',
        'observations_adicionais',

        'parcial_1_at',
        'parcial_2_at',
        'parcial_3_at',
        'parcial_4_at',
        'parcial_5_at',
        'parcial_6_at',

        'apr_at',
        'apr_id',

        'status',
        'status_execution',
        'status_closing',

        'enel_deadline',
        'viability_execution_date',
        'work_start_date',
        'work_end_date',

        'enviado_enel',
        'aprovado_enel',
        'fiscalizado_satel',
        'liberado_medicao',
        'data_pagamento_projeto',
        'is_civil',
        'observation_status',
        'month_date',

        'tipo_obra',
        'sigeo'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'enel_deadline' => Date::class,
        'viability_execution_date' => Date::class,
        'work_start_date' => Date::class,
        'work_end_date' => Date::class,
        'data_pagamento_projeto' => Date::class,

        'apr_at' => Date::class,
        'status_closing' => RdseClosingStatus::class,
        'is_civil' => 'boolean',
    ];

    public function services()
    {
        return $this->hasMany(RdseServices::class, 'rdse_id', 'id');
    }

    public function resbs()
    {
        return $this->hasMany(Resb::class, 'rdse_id', 'id');
    }

    public function activities()
    {
        return $this->hasMany(RdseActivity::class, 'rdse_id', 'id');
    }

    public function getMonthAttribute()
    {
        if (empty($this->month_date) || $this->month_date == '0000-00-00 00:00:00') {
            return null;
        }

        return Carbon::parse($this->month_date)->format('m');
    }

    public function getYearAttribute()
    {
        if (empty($this->month_date) || $this->month_date == '0000-00-00 00:00:00') {
            return null;
        }

        return Carbon::parse($this->month_date)->format('Y');
    }

    public function getAtividadesDescriptionsAttribute($filters = [])
    {
        $html = '';

        $datesPeriodoSearch = null;

        if (!empty($filters['period'])) {
            $datesPeriodoSearch = calculateDates(
                $filters['period'],
                $filters['start_at'],
                $filters['end_at']
            );
        }

        $atividades = $this->activities()
            ->where(function ($query) use ($filters) {
                if (!empty($filters['atividades']) && $filters['atividades'] != 'all') {
                    if ($filters['atividades'] == 'nao_execucao') {
                        $query->whereNull('execucao'); // Filtra apenas atividades com execução nula
                    } else if ($filters['atividades'] == 'execucao') {
                        $query->whereNotNull('execucao'); // Filtra atividades com execução preenchida
                    }
                }
            })


            ->where(function ($query) use ($datesPeriodoSearch) {
                if (!empty($datesPeriodoSearch)) {
                    if ($datesPeriodoSearch['start_at'] == $datesPeriodoSearch['end_at']) {
                        $query->whereDate('data', [$datesPeriodoSearch['start_at']]);
                    } else {
                        $query->whereBetween('data', [$datesPeriodoSearch['start_at'], $datesPeriodoSearch['end_at']]);
                    }
                }
            })

            ->where(function ($q) use ($filters) {

                if (isset($filters['hour']) && $filters['hour'] != 'all') {
                    $q->where( function ($query) use ($filters) {
                        $turno = $filters['hour'];

                        if ($turno === 'diurno') {
                            $query->whereTime('data_inicio', '>=', '07:00')
                                  ->whereTime('data_inicio', '<', '19:00');
                        } elseif ($turno === 'noturno') {
                            // Turno noturno: das 19:40 às 06:00 (passando pela meia-noite)
                            $query->where(function ($subQuery) {
                                $subQuery->whereTime('data_inicio', '>=', '19:40')
                                         ->whereTime('data_inicio', '<=', '23:59')
                                         ->orWhereTime('data_inicio', '>=', '00:00')
                                         ->whereTime('data_inicio', '<', '06:00');
                            });
                        }
                    });
                }
            })

            ->orderBy('data', 'desc')->limit(6)->get();

        if ($atividades->count() == 0) {
            return  $html = 'Sem atividades';
        }

        foreach ($atividades as $atividade) {

            if ($atividade->atividade_descricao == 'Cancelada') {
                $exec = '<span class="text-warning">Cancelada</span>';
            } else {
                $exec = !empty($atividade->execucao) ? '<span class="text-success">Executado</span>' : '<span>Não Executado</span>';
            }

            $text = $atividade->atividade_descricao . ' ' . $atividade->equipe->name . ' ' . $atividade->data . ' ' . $atividade->data_inicio . '-' . $atividade->data_fim . ' - ' . $exec . '<br>';

            $html .= $text;
        }

        $html .= '...';

        return $html;
    }

    public function getServicesTotal()
    {
        $services = $this->services();

        $column = 'preco';

        if ($this->parcial_1 == true) {
            $column = 'p_preco1';
        }

        if ($this->parcial_2 == true) {
            $column = 'p_preco2';
        }

        if ($this->parcial_3 == true) {
            $column = 'p_preco3';
        }

        return [
            'p' => $services->sum($column),
            'total' => $services->sum('preco'),
        ];
    }

    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'pending':
                $label = 'warning';
                break;
            case 'approved':
                $label = 'success';
                break;
            default:
                $label = 'info';
                break;
        }

        return $label;
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = maiusculo($value);
    }

    public function setEquipeAttribute($value)
    {
        $this->attributes['equipe'] = maiusculo($value);
    }

    public function setSolicitanteAttribute($value)
    {
        $this->attributes['solicitante'] = ucfirst($value);
    }

    public function setDateNfeAtAttribute($value)
    {
        $this->attributes['date_nfe_at'] = return_format_date($value, 'en');
    }

    public function setCroquiAtualizadoDataAttribute($value)
    {
        $this->attributes['croqui_atualizado_data'] = return_format_date($value, 'en');
    }

    public function setCroquiValidadoDataAttribute($value)
    {
        $this->attributes['croqui_validado_data'] = return_format_date($value, 'en');
    }

    public function setCroquiFinalizadoDataAttribute($value)
    {
        $this->attributes['croqui_finalizado_data'] = return_format_date($value, 'en');
    }

    public function setAtAttribute($value)
    {
        $this->attributes['at'] = return_format_date($value, 'en');
    }

    public function canResetResb()
    {
        return auth()->user()->id === 1 || auth()->user()->id === 8;
    }
}
