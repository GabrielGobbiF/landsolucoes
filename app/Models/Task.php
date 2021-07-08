<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tar_titulo',
        'tar_descricao',
        'tar_prazo',
        'tar_status',
        'prioridade',
        'data',
    ];


}
