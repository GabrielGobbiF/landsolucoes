<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Uploaded extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'parentable_type',
        'parentable_id',
        'name',
        'file_name',
        'mime_type',
        'path',
        'extension',
        'disk',
        'file_hash',
        'collection',
        'is_cover',
        'source',
        'uploaded_images',
        'uploader_id',
    ];

    public function parentable()
    {
        return $this->morphTo();
    }
}
