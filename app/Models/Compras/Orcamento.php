<?php

namespace App\Models\Compras;

use App\Models\Obra;
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

    public function obra()
    {
        return $this->belongsTo(Obra::class, 'obra_id');
    }
}
