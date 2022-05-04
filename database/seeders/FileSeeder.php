<?php

namespace Database\Seeders;

use App\Models\File;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'image-1',
                'path' => 'image (1).jpg'
            ],
            [
                'name' => 'image-2',
                'path' => 'image (2).jpg'
            ],
            [
                'name' => 'image-3',
                'path' => 'image (3).jpg'
            ],
            [
                'name' => 'image-4',
                'path' => 'image (4).jpg'
            ],
            [
                'name' => 'image-5',
                'path' => 'image (5).jpg'
            ]
        ];
        foreach ($data as $item) {
            File::factory()->create([
                'name' => $item['name'],
                'path' => $item['path']
            ]);
        }
    }
}
