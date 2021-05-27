<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'dep_responsavel',
        'dep_telefone_celular',
        'dep_telefone_fixo',
        'dep_email',
        'dep_funcao',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
