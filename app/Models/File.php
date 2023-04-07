<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $with = ['user', 'epi'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'file_name',
        'mime_type',
        'path',
        'disk',
        'file_hash',
        'collection',
        'size',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function epi()
    {
        return $this->morphTo(Epi::class, 'service', 'service_id', 'id');
    }
}
