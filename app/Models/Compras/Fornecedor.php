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

    public const RELATIONSHIP_PAGES_LINK = 'fornecedores_atuacao';

    public function atuacao()
    {
        return $this->belongsToMany(Atuacao::class, self::RELATIONSHIP_PAGES_LINK);
    }

    public function contatos()
    {
        return $this->morphMany(Contato::class, 'item');
    }
}
