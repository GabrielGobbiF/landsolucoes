<?php

namespace App\Models\Compras;

use App\Traits\SlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, SlugTrait;

    protected $fillable = [
        'name',
        'slug',
    ];
}
