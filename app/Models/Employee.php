<?php

namespace App\Models;

use App\Traits\LogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Employee extends Model
{
    use HasFactory, LogTrait,LogsActivity;

    protected $fillable = ['name', 'rg', 'ctps', 'endereco', 'estado_civil', 'cargo', 'salario', 'cnh', 'email', 'equipe', 'cnh_number', 'cnh_validity','date_contract'];

    protected static $logAttributes = ['name', 'rg', 'ctps', 'endereco', 'estado_civil', 'cargo', 'salario', 'cnh', 'email','equipe', 'cnh_validity','cnh_number', 'date_contract'];

    protected static $logName = 'Employee';

    public function auditory()
    {
        return $this->hasMany(Auditory::class, 'employee_id', 'id');
    }
}
