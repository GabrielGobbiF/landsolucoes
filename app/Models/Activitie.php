<?php

namespace App\Models;

use App\Casts\Date;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activitie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'text',
        'fixed',
    ];

    protected $casts = [
        'fixed' => 'boolean',
        'created_at' => Date::class
    ];

    public function user()
    {
        return $this->BelongsTo(User::class);
    }

    protected function fixed(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $value ? '1' : '0';
            },
            set: function ($value) {
                return $value == true ? '1' : '0';
            }
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = auth()->id();
        });
    }
}
