<?php

namespace Database\Seeders;

use App\Models\Discount;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductInventory;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        ProductCategory::factory(30)->create();
        ProductInventory::factory(30)->create();
        Discount::factory(10)->create();
        Product::factory(30)->create();
        User::factory(10)->create();
    }
}
