<?php

namespace Database\Seeders;

use App\Models\ProductInventory;
use Illuminate\Database\Seeder;

class ProductInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductInventory::factory(30)->create();
    }
}
