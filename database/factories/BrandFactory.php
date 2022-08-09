<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
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

        $data =  ['name' => $this->faker->word()];

        $randomState = $this->faker->randomElement([true, false]);
        if ($randomState === true) {
            $data['file_id'] = $fileId;
        } else {
            $data['image_url'] = $imageURL;
        }

        return $data;
    }
}
