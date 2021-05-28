<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concessionaria extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class, 'concessionaria_id');
    }
}
