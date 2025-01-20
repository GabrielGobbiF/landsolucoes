<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientFormInvoicing extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cnpj',
        'inscricao_estadual',
        'inscricao_municipal',
        'razao_social',
        'nome_fantasia',
        'endereco_cobranca',
        'email_financeiro',
        'email_engenheiro',
        'telefones',
        'nome_obra',
        'endereco_obra',
        'cno',
        'sfobras',
        'n_contrato_proposta',
        'n_pedido_os',
        'retencao_contratual',
        'isencao_iss',
        'observations',
        'data_preenchimento',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'retencao_contratual' => 'boolean',
        'isencao_iss' => 'boolean',
        'data_preenchimento' => 'date',
    ];

    public function uploads()
    {
        return $this->morphMany(Uploaded::class, 'parentable');
    }
}
