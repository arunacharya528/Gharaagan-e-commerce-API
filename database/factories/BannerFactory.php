<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'image' => $this->faker->imageUrl(1080, 500),
            'link' => "#",
            'size' => $this->faker->randomElement(['small', 'medium', 'large']),
            'type' => $this->faker->randomElement(['banner', 'promotion']),
            'active' => true
        ];
    }
}
