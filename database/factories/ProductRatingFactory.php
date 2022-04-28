<?php

namespace Database\Factories;

use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductRatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => $this->faker->randomElement(Product::pluck('id')),
            'user_id' => $this->faker->randomElement(User::pluck('id')),
            'order_id' => $this->faker->randomElement(OrderDetail::pluck('id')),
            'rate' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'comment' => $this->faker->paragraph(10)
        ];
    }
}
