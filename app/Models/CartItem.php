<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $fillable = ['session_id', 'product_id', 'quantity','inventory_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function shoppingSession()
    {
        return $this->belongsTo(ShoppingSession::class, 'session_id');
    }
}
