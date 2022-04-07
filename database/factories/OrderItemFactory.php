<?php

namespace Database\Factories;

use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductInventory;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => $this->faker->randomElement(OrderDetail::pluck('id')),
            'product_id' => $this->faker->randomElement(Product::pluck('id')),
            'inventory_id' => $this->faker->randomElement(ProductInventory::pluck('id')),
            'quantity' => rand(20, 50)
        ];
    }
}
