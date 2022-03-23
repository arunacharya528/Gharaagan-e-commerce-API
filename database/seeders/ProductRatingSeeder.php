<?php

namespace Database\Seeders;

use App\Models\ProductRating;
use Illuminate\Database\Seeder;

class ProductRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductRating::factory(100)->create();
    }
}
