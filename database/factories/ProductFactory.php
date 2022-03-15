<?php

namespace Database\Factories;

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
            'SKU' => $this->faker->uuid(),
            'price' => rand(1000, 2000),
            'category_id' => $this->faker->randomElement(ProductCategory::pluck('id')),
            'inventory_id' => $this->faker->randomElement(ProductInventory::pluck('id')),
            'discount_id' => $this->faker->randomElement(Discount::pluck('id')),
            'views' => rand(1000, 1500)

        ];
    }
}
