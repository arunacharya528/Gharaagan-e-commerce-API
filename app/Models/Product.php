<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'summary', "SKU", "price", "category_id", 'discount_id', 'brand_id', 'views'];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function inventories()
    {
        return $this->hasMany(ProductInventory::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function ratings()
    {
        return $this->hasMany(ProductRating::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function questions()
    {
        return $this->hasMany(QuestionAnswer::class);
    }
}
