<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ShoppingSession;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'session_id' => $this->faker->randomElement(ShoppingSession::pluck('id')),
            'product_id' => $this->faker->randomElement(Product::pluck('id')),
            'quantity' => rand(20, 50)

        ];
    }
}
