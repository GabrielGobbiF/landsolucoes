<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Documento extends Model
{
    use HasFactory, SoftDeletes;

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
            ->where('favoritable_id', $this->id)
            ->where('favoritable_type', 'App\Models\Documento')
            ->first();
    }
}
