<?php

namespace App\Models;

use App\Casts\Date;
use App\Traits\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory, SearchableTrait;

    public $searchable = ['id', 'name', 'cnh_validity', 'cnh_number', 'cnh_category', 're', 'cpf'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cpf',
        'cnh_validity',
        'cnh_number',
        'cnh_category',
        're',
    ];

      /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'cnh_validity' => Date::class,
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'service');
    }

}
