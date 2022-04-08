<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertisementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $currentDate = strtotime(date("Y-m-d"));
        $futureDate = $currentDate + (60 * 60 * 24 * 30);
        return [
            'name' => $this->faker->word(),
            'summary' => $this->faker->paragraph(5),
            'url_slug' => "https://www.google.com/search?q=" . $this->faker->word(),
            'page' => $this->faker->randomElement(['home', 'detail', 'filter', 'profile']),
            'type' => $this->faker->randomElement(['banner', 'promotion', 'category']),
            'active' => $this->faker->randomElement([true, false]),
            'active_from' => date('Y-m-d H:i:s', $currentDate),
            'active_to' => date('Y-m-d H:i:s', $futureDate),
        ];
    }
}
