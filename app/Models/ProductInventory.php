<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInventory extends Model
{
    use HasFactory;
    protected $fillable = ['quantity', 'product_id', 'type', 'discount_id', 'price'];

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }
}
