<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etd extends Model
{
    use HasFactory;

    protected $with = ['files'];

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
