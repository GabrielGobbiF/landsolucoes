<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Employee extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['name', 'rg', 'ctps', 'endereco', 'estado_civil', 'cargo', 'salario', 'cnh', 'email', 'cnh_number', 'date_contract'];

    protected static $logAttributes = ['name', 'rg', 'ctps', 'endereco', 'estado_civil', 'cargo', 'salario', 'cnh', 'email', 'cnh_number', 'date_contract'];

    protected static $logName = 'Employee';

    public function auditory()
    {
        return $this->hasMany(Auditory::class, 'employee_id', 'id');
    }
}
