<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'rg', 'ctps', 'endereco', 'estado_civil', 'cargo', 'salario', 'cnh', 'email', 'url'];
}
