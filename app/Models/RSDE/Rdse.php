<?php

namespace App\Models\RSDE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rdse extends Model
{
    use HasFactory, SoftDeletes;

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
        'lote'
    ];

    protected $appends = ['StatusLabel'];

    public function services()
    {
        return $this->hasMany(RdseServices::class, 'rdse_id', 'id');
    }

    public function getServicesTotal()
    {
        return $this->services()->sum('preco');
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

    public function setAtAttribute($value)
    {
        $this->attributes['at'] = return_format_date($value, 'en');
    }
}
