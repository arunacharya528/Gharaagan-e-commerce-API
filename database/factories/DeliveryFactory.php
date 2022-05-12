<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'region' => $this->faker->city(),
            'price' => $this->faker->randomElement([100, 80])
        ];
    }
}
