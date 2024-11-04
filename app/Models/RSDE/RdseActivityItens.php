<?php

namespace App\Models\RSDE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdseActivityItens extends Model
{
    use HasFactory;

    protected $table = 'rdse_atividade_itens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rdse_atividade_id',
        'rdse_id',
        'handsworks_id',
        'description',
    ];

    public function handswork()
    {
        return $this->belongsTo(Handswork::class, 'handsworks_id', 'id');
    }
}
