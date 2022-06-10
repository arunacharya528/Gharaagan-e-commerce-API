<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\QuestionAnswer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionAnswerFactory extends Factory
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
            'question' => $this->faker->paragraph(),
            'answer' => $this->faker->paragraph(),
        ];
    }
}
