<?php

namespace App\Models\Compras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'obra_id',
        'status',
    ];

    public function itens()
    {
        #return $this->hasMany(Produto::class, 'id_obra');
    }
}
