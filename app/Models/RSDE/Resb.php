<?php

namespace App\Models\RSDE;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resb extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rdse_id',
        'item_id',
        'qnt_planejada',
        'qnt_viabilidade',
        'qnt_executada',
    ];

    protected $casts = [
        'qnt_planejada' => 'float',
        'qnt_viabilidade' => 'float',
        'qnt_executada' => 'float',
    ];

    protected $decimalFields = ['qnt_planejada', 'qnt_executada', 'qnt_viabilidade'];

    protected static function booted()
    {
        static::saving(function ($model) {
            $model->formatDecimalFields();
        });
    }

    /**
     * Formata os campos decimais, substituindo vírgula por ponto.
     */
    protected function formatDecimalFields()
    {
        foreach ($this->decimalFields as $field) {
            if (isset($this->attributes[$field]) && is_string($this->attributes[$field])) {
                $this->attributes[$field] = (float) str_replace(',', '.', $this->attributes[$field]);
            }
        }
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'item_id', 'id');
    }
}
