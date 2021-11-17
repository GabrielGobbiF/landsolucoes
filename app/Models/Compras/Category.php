<?php

namespace App\Models\Compras;

use App\Traits\SlugTrait;
use App\Traits\TitleCaseTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory, SlugTrait, TitleCaseTrait;

    protected $fillable = [
        'name',
        'slug',
    ];

    public const RELATIONSHIP_CATEGORIES_SUBCATEGORIES = 'categories_subcategories';

    public function subCategories()
    {
        return $this->belongsToMany(SubCategory::class, self::RELATIONSHIP_CATEGORIES_SUBCATEGORIES);
    }

    public function noHasCategories()
    {
        return SubCategory::whereNotIn('sub_categories.id', function($query) {
            $query->select('categories_subcategories.sub_category_id');
            $query->from('categories_subcategories');
            $query->whereRaw("categories_subcategories.sub_category_id={$this->id}");
        })->get();
    }
}
