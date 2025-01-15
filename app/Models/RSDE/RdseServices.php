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

        'p_quantidade1',
        'p_quantidade2',
        'p_quantidade3',
        'p_quantidade4',
        'p_quantidade5',
        'p_quantidade6',

        'p_preco1',
        'p_preco2',
        'p_preco3',
        'p_preco4',
        'p_preco5',
        'p_preco6',
    ];

    public $preventAttrSet = true;

    public function getPrecoAttribute()
    {
        return $this->preventAttrSet
            ? maskPrice($this->attributes['preco'])
            : $this->attributes['preco'];
    }

    public function getPPreco1Attribute()
    {
        return $this->preventAttrSet
            ? maskPrice($this->attributes['p_preco1'])
            : $this->attributes['p_preco1'];
    }

    public function getPPreco2Attribute()
    {
        return $this->preventAttrSet
            ? maskPrice($this->attributes['p_preco2'])
            : $this->attributes['p_preco2'];
    }

    public function getPPreco3Attribute()
    {
        return $this->preventAttrSet
            ? maskPrice($this->attributes['p_preco3'])
            : $this->attributes['p_preco3'];
    }

    public function getPPreco4Attribute()
    {
        return $this->preventAttrSet
            ? maskPrice($this->attributes['p_preco4'])
            : $this->attributes['p_preco4'];
    }

    public function getPPreco5Attribute()
    {
        return $this->preventAttrSet
            ? maskPrice($this->attributes['p_preco5'])
            : $this->attributes['p_preco5'];
    }

    public function getPPreco6Attribute()
    {
        return $this->preventAttrSet
            ? maskPrice($this->attributes['p_preco6'])
            : $this->attributes['p_preco6'];
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

    public function partials()
    {
        return $this->hasMany(RdseServicesPartials::class, 'rdse_service_id', 'id');
    }

    public function setPreventAttrSet($value)
    {
        $this->preventAttrSet = $value;
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('visible', function (Builder $builder) {
            $builder->orderBy('order');
        });
    }
}
