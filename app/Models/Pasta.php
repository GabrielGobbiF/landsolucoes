<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasta extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'url',
        'folder_childer',
        'type_id'
    ];

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'folder', 'uuid');
    }

    public function childrens()
    {
        return Pasta::where('folder_childer', $this->uuid)
            ->orderBy('name', 'ASC')
            ->get();
    }
}
