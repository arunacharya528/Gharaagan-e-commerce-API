<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomElement(User::pluck('id')),
            'address_line1' => $this->faker->address(),
            'address_line2' => $this->faker->address(),
            'city' => $this->faker->city(),
            'telephone' => $this->faker->phoneNumber(),
            'mobile' => $this->faker->phoneNumber()
        ];
    }
}
