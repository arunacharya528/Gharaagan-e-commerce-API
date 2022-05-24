<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            $category = ProductCategory::factory()->create([
                'is_parent' => true
            ]);

            ProductCategory::factory(10)->create([
                'parent_id' => $category->id,
                'is_parent' => false
            ]);
        }
    }
}
