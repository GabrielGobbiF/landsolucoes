<?php

namespace App\Models\RSDE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rdse extends Model
{
    use HasFactory;

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
        'status',
    ];

    protected $appends = ['StatusLabel'];

    public function services()
    {
        return $this->hasMany(RdseServices::class, 'rdse_id', 'id');
    }

    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'finished':
                $label = 'warning';
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
