<?php

namespace Database\Seeders;

use App\Models\Delivery;
use Database\Factories\DeliveryFactory;
use Illuminate\Database\Seeder;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Delivery::factory(10)->create();
    }
}
