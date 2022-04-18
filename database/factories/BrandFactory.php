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
        // return [
        //     'name'=>$this->faker->word(),
        //     'image'=>$this->faker->imageUrl()
        // ];

        $fileId = $this->faker->randomElement(File::pluck('id'));
        $imageURL = $this->faker->imageUrl();

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
