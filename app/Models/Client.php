<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasPermissionsTrait;

class Client extends Authenticatable
{
    use HasFactory, Notifiable, HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'company_name',
        'username',
        'cnpj',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];

    public function departments()
    {
        return $this->hasMany(Department::class, 'client_id');
    }

    public function obras()
    {
        return $this->belongsTo(Obra::class, 'id', 'client_id');
    }

}
