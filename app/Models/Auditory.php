<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditory extends Model
{
    use HasFactory;

    protected $table = 'employees_auditory';

    protected $fillable = ['name', 'description', 'type', 'employee_id', 'order', 'epi', 'option_name', 'doc_applicable', 'doc_along_month', 'status', 'document_link', 'employee_id', 'updated_by', 'is_active', 'reason_change'];
}
