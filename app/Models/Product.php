<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', "SKU", "price", "category_id", "inventory_id", 'discount_id', 'views'];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function inventory()
    {
        return $this->belongsTo(ProductInventory::class, 'inventory_id');
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
}
