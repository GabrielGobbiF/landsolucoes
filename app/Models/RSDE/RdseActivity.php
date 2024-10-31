<?php

namespace App\Models\RSDE;

use App\Casts\Date;
use App\Models\Activitie;
use App\Models\Equipe;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdseActivity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rdse_id',
        'equipe_id',
        'atividade',
        'data',
        'data_inicio',
        'data_fim',
        'execucao'
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => Date::class,
        'execucao' => Date::class,
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
}
