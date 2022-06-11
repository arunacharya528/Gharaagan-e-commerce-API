<?php

namespace Database\Seeders;

use App\Models\PageLink;
use Illuminate\Database\Seeder;

class PageLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PageLink::factory(50)->create();
    }
}
