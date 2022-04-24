<?php

namespace Database\Factories;

use App\Models\Discount;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailFactory extends Factory
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
            'total' => rand(2000, 3000),
            'status' => $this->faker->randomElement([
                'Order Placed',
                'Product collected for delivery',
                'Product being Shipped',
                'Product Received'
            ]),
            'discount_id' => $this->faker->randomElement([null, $this->faker->randomElement(Discount::pluck('id'))]),
            'address_id' => $this->faker->randomElement(UserAddress::pluck('id'))
        ];
    }
}
