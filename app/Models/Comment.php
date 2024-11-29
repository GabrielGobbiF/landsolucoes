<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'etapa_id',
        'user_id',
        'obs_texto',
        'type',
    ];

    protected $table = 'comments';

    public function user()
    {
        return $this->type == 'usuario'
            ? $this->belongsTo(User::class, 'user_id')
            : $this->belongsTo(Client::class, 'user_id');
    }

    public function etapa()
    {
        return $this->belongsTo(ObraEtapa::class, 'etapa_id', 'id');
    }

    protected static function booted()
    {
        static::saved(function ($observacao) {
            $observacao->etapa->obra->touch(); // Atualiza o `updated_at` da obra
        });

        static::deleted(function ($observacao) {
            $observacao->etapa->obra->touch(); // Atualiza o `updated_at` da obra
        });
    }
}
