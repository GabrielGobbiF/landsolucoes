<?php

namespace App\Models\RSDE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Rdse extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $logName = 'RDSE';

    #protected static $ignoreChangedAttributes   =  ['observations'];

    #protected static $logAttributesToIgnore  =  ['observations'];

    #protected static $logOnlyDirty = true;getServicesTotal

    #protected static $submitEmptyLogs = false;

    protected static $logAttributes = [
        'description',
        'n_order',
        'equipe',
        'solicitante',
        'at',
        'type',
        'modelo',
        'status',
        'obra_id',
        'lote',
        'observations',
        'observations_execution',
        'nf',
        'date_nfe_at',
        'croqui_atualizado_data',
        'croqui_atualizado_responsavel',
        'croqui_validado_data',
        'croqui_validado_responsavel',
        'croqui_finalizado_data',
        'croqui_finalizado_responsavel',

        'parcial_1_at',
        'parcial_2_at',
        'parcial_3_at',
        'status_execution',
    ];

    protected $appends = ['StatusLabel'];

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
        'status',
        'obra_id',
        'lote',
        'observations',
        'nf',
        'date_nfe_at',
        'croqui_atualizado_data',
        'croqui_atualizado_responsavel',
        'croqui_validado_data',
        'croqui_validado_responsavel',
        'croqui_finalizado_data',
        'croqui_finalizado_responsavel',
        'observations_execution',
        
        'parcial_1_at',
        'parcial_2_at',
        'parcial_3_at',
        'status_execution',
    ];

    public function services()
    {
        return $this->hasMany(RdseServices::class, 'rdse_id', 'id');
    }

    public function getServicesTotal()
    {
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

        return $this->services()->sum($column);
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
}
