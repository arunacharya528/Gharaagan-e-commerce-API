<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Discount;
use App\Models\ProductCategory;
use App\Models\ProductInventory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'summary' => $this->faker->sentence(),
            'category_id' => $this->faker->randomElement(ProductCategory::pluck('id')),
            'brand_id' => $this->faker->randomElement(Brand::pluck('id')),
        ];
    }
}
