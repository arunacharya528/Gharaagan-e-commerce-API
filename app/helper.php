<?php

use App\Models\ShoppingSession;

/**
 * Evaluates the shopping session and calculates total according to cart items
 */
function evaluate($session_id)
{
    $session = ShoppingSession::with('cartItems.product.images')->find($session_id);
    $totalCost = 0;
    foreach ($session->cartitems as $item) {
        $price = $item->product->price;
        $discountP = $item->product->discount->discount_percent;
        $quantity = $item->quantity;
        $actualUnitPrice = $price - (0.01 * $discountP * $price);
        $totalCost += $actualUnitPrice * $quantity;
    }

    $session->total = $totalCost;
    $session->save();
}
