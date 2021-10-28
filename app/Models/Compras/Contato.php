<?php

namespace App\Models\Compras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_type',
        'item_id',
        'nome',
        'telefone',
        'celular',
        'email',
    ];

    public function setTelefoneAttribute($value)
    {
        $this->attributes['telefone'] = clear($value);
    }

    public function setCelularAttribute($value)
    {
        $this->attributes['celular'] = clear($value);
    }
}
