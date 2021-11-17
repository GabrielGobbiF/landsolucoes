<?php

namespace App\Models\Compras;

use App\Traits\SlugTrait;
use App\Traits\TitleCaseTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory, SlugTrait, TitleCaseTrait;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, Category::RELATIONSHIP_CATEGORIES_SUBCATEGORIES);
    }
}
