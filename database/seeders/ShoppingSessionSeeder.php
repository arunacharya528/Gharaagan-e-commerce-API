<?php

namespace Database\Seeders;

use App\Models\ShoppingSession;
use Illuminate\Database\Seeder;

class ShoppingSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShoppingSession::factory(30)->create();
    }
}
