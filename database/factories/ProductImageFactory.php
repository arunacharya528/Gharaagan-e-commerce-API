<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fileId = $this->faker->randomElement(File::pluck('id'));
        $images = ['animals', 'arch', 'nature', 'people', 'tech'];
        $imageURL = "https://placeimg.com/1000/700/" . $this->faker->randomElement($images);
        $data =  [
            'product_id' => $this->faker->randomElement(Product::pluck('id')),
        ];

        $randomState = $this->faker->randomElement([true, false]);
        if ($randomState === true) {
            $data['file_id'] = $fileId;
        } else {
            $data['image_url'] = $imageURL;
        }

        return $data;
    }
}
