<?php

namespace App\Models\Compras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'descricao',
        'slug',
        'unidade',
        'categoria',
        'valor',
    ];

    public function setValorAttribute($value)
    {
        $value = str_replace('.', ',', $value);
        $this->attributes['valor'] = clearNumber($value);
    }
}
