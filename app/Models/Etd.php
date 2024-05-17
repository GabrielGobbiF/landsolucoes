<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Etd extends Model
{
    use HasFactory, Cachable;

    protected $with = [];

    protected $table = 'edp';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'id',
        'nome',
        'sigla',
        'endereco',
        'bairro',
        'municipio',
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'service');
    }
}
