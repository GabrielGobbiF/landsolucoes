<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasta extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'folder_childer'
    ];

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'folder', 'uuid');
    }

}
