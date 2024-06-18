<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasPermissionsTrait;
use App\Traits\LogTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasPermissionsTrait, LogTrait,LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'rg',
        'password',
        'telefone_celular',
        'uuid',
        'is_active',
        'cnh',
        'cnh_validity',
        'cnh_number',
        'cnh_category',
        'username',
        'password_verified',
        're'
    ];

    protected static $logAttributes = [
        'name',
        'email',
        'rg',
        'password',
        'telefone_celular',
        'uuid',
        'is_active',
        'cnh',
        'cnh_validity',
        'cnh_number',
        'cnh_category',
        'username',
        'password_verified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'id',
        'username',
        'password_verified'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function filesFavorites()
    {
        return $this->morphedByMany(Documento::class, 'favoritable');
    }

    public function obrasFavorites()
    {
        return $this->morphedByMany(Obra::class, 'favoritable');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id', 'id');
    }

    /**
     * Favorite the current reply.
     *
     * @return Model
     */
    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }
}
