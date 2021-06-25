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
    ];

    protected $table = 'comments';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
