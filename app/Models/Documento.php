<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'folder',
        'url',
        'slug',
        'ext',
        'folder'
    ];

    public function getDescAttribute()
    {
        return getIconByExtDoc($this->ext);
    }

    public function favorited(): bool
    {
        return (bool) Favorite::where('user_id', Auth::id())
            ->where('file_id', $this->id)
            ->first();
    }
}
