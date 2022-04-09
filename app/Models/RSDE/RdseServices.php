<?php

namespace App\Models\RSDE;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdseServices extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'codigo_sap',
        'chegada',
        'saida',
        'minutos',
        'horas',
        'description',
        'qnt_atividade',
        'preco',
        'type',
    ];

    public function getPrecoAttribute()
    {
        return maskPrice($this->attributes['preco']);
    }

    public function setPrecoAttribute($value)
    {
        $this->attributes['preco'] = clearNumber($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = maiusculo($value);
    }

    public function handswork()
    {
        return $this->belongsTo(Handswork::class, 'codigo_sap', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('visible', function (Builder $builder) {
            $builder->orderBy('order');
        });
    }
}
