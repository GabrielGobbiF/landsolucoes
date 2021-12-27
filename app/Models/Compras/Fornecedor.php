<?php

namespace App\Models\Compras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'razao_social',
        'cnpj',
        'endereco',
    ];

    public const RELATIONSHIP_FORNECEDOR_ATUACAO = 'fornecedores_atuacao';

    public function atuacao()
    {
        return $this->belongsToMany(Category::class, self::RELATIONSHIP_FORNECEDOR_ATUACAO);
    }

    public function contatos()
    {
        return $this->morphMany(Contato::class, 'item');
    }
}
