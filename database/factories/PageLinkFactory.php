<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageLinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'location' => $this->faker->randomElement(['head', 'left-foot', 'right-foot', 'middle-foot']),
            'url-slug' => $this->faker->randomElement(Page::pluck('slug')),
            'name' => $this->faker->word()
        ];
    }
}
