<?php

namespace App\Models;

use App\Casts\Date;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResbRequisicao extends Model
{
    use HasFactory;

    protected $table = 'resb_requisicoes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'item_id',
        'rdse_id',
        'resb_id',
        'qnt',
        'at',
        'unique',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'at' => Date::class,
    ];
}
