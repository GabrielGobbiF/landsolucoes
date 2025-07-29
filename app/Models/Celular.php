<?php

namespace App\Models;

use App\Traits\LogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Celular extends Model
{
    use HasFactory, LogTrait, LogsActivity, SoftDeletes;

    protected static $logName = 'Celulares';

    protected static $logAttributes = [
        'usuario',
        'responsavel',
        'equipe',
        'linha',
        'departamento',
        'centro_custo',
        'assinatura',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario',
        'responsavel',
        'equipe',
        'linha',
        'departamento',
        'centro_custo',
        'imei',
        'assinatura',
    ];

    protected $table = 'celulares';

    public function setLinhaAttribute($value)
    {
        $this->attributes['linha'] = limpar($value, '');
    }

    public function setUsuarioAttribute($value)
    {
        $this->attributes['usuario'] = maiusculo($value, '');
    }

    public function setResponsavelAttribute($value)
    {
        $this->attributes['responsavel'] = maiusculo($value, '');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'service');
    }
}
