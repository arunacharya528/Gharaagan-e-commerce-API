<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'is_parent', 'parent_id'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function category()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id');
    }

    public function childCategories()
    {
        return $this->category()->with('childCategories');
    }
}
