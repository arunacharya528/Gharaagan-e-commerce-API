<?php

namespace Database\Factories;

use App\Models\Discount;
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
        $data = [
            'product_id' => $this->faker->randomElement(Product::pluck('id')),
            'discount_id' => $this->faker->randomElement(Discount::pluck('id')),
            'type' => $this->faker->randomElement($this->faker->words(5)),
            'price' => rand(1000, 2000),
        ];

        if ($this->faker->randomElement([true, false])) {
            $data['quantity'] = 0;
        } else {
            $data['quantity'] = rand(100, 200);
        }

        return $data;
    }
}
