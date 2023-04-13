<?php

namespace App\Models;

use App\Casts\FileStorage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $with = ['user', 'etd'];

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
        'observations',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'path' => FileStorage::class,
    ];

    protected $appends = ['FolderPastName'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function epi()
    {
        return $this->morphTo(Epi::class, 'service', 'service_id', 'id');
    }

    public function etd()
    {
        return $this->morphTo(Etd::class, 'service', 'service_id', 'id');
    }

    public function getFolderPastNameAttribute()
    {
        return Carbon::parse($this->create_at)->format('d-m-Y');
    }
}
