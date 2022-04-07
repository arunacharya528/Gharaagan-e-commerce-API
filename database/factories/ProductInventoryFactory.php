<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductInventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity' => rand(100, 200),
            'product_id' => $this->faker->randomElement(Product::pluck('id')),
            'type' => $this->faker->randomElement($this->faker->words(5))
        ];
    }
}
