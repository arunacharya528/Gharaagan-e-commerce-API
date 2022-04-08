<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProductCategorySeeder::class);
        $this->call(DiscountSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductInventorySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UserAddressSeeder::class);
        $this->call(ShoppingSessionSeeder::class);
        $this->call(CartItemSeeder::class);
        $this->call(OrderDetailSeeder::class);
        $this->call(OrderItemSeeder::class);
        $this->call(AdvertisementSeeder::class);
        $this->call(ProductImageSeeder::class);
        $this->call(ProductRatingSeeder::class);
        $this->call(QuestionAnswerSeeder::class);
    }
}
