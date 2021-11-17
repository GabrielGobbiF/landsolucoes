<?php

namespace App\Models\Compras;

use App\Traits\SlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory, SlugTrait;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, Category::RELATIONSHIP_CATEGORIES_SUBCATEGORIES);
    }
}
