<?php

namespace App\Models\RSDE;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdseServicesPartials extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'rdse_services_partials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quantidade',
        'preco',
        'rdse_id',
        'partial',
    ];

    protected $hidden = [
        'id',
        'rdse_service_id'
    ];

   
}
