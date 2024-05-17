<?php

namespace App\Models\Compras;

use App\Models\Variable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'etapas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'descricao',
        'quantidade',
        'preco',
        'unidade',
        'categoria',
        'sub_categoria',
    ];

    public function variables()
    {
        return $this->hasMany(Variable::class, 'etapa_id');
    }

    public function setPrecoAttribute($value)
    {
        #$value = str_replace('.', ',', $value);
        $this->attributes['preco'] = clearNumber($value);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('compras', function (Builder $builder) {
            $builder->where('tipo_id', 4);
        });

        static::creating(function ($model) {
            $model->tipo_id = 4;
        });
    }
}
