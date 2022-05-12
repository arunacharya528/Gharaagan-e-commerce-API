<?php

namespace Database\Factories;

use App\Models\Delivery;
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
            'delivery_id' => $this->faker->randomElement(Delivery::pluck('id')),
            'telephone' => $this->faker->phoneNumber(),
            'mobile' => $this->faker->phoneNumber()
        ];
    }
}
