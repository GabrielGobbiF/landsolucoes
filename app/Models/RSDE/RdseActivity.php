<?php

namespace App\Models\RSDE;

use App\Casts\Date;
use App\Models\Activitie;
use App\Models\Encarregado;
use App\Models\Equipe;
use App\Models\Supervisor;
use App\Models\Uploaded;
use App\Models\Vehicle;
use App\Traits\LogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class RdseActivity extends Model
{
    use HasFactory, LogTrait, LogsActivity, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rdse_id',
        'equipe_id',
        'veiculo_id',
        'supervisor_id',
        'diretoria',
        'encarregado_id',
        'atividade_descricao',
        'atividades',
        'data',
        'data_inicio',
        'data_fim',
        'execucao',
        'civil',
        'tipo_ordem',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => Date::class,
        'execucao' => Date::class,
        'civil' => 'boolean',
    ];

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }

    public function rdse()
    {
        return $this->belongsTo(Rdse::class);
    }

    public function atividades()
    {
        return $this->hasMany(RdseActivityItens::class, 'rdse_atividade_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'supervisor_id', 'id');
    }

    public function encarregado()
    {
        return $this->belongsTo(Encarregado::class, 'encarregado_id', 'id');
    }

    public function veiculo()
    {
        return $this->belongsTo(Vehicle::class, 'veiculo_id', 'id');
    }

    public function canUpdate()
    {
        return empty($this->execucao);
    }

    public function uploads()
    {
        return $this->morphMany(Uploaded::class, 'parentable');
    }
}
