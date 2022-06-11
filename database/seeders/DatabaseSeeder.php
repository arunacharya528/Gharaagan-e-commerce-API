<?php

namespace Database\Seeders;

use App\Models\PageLink;
use Database\Factories\DeliveryFactory;
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
        $this->call(UserSeeder::class);
        $this->call(DeliverySeeder::class);
        $this->call(UserAddressSeeder::class);

        $this->call(ProductCategorySeeder::class);
        $this->call(DiscountSeeder::class);

        $this->call(FileSeeder::class);
        $this->call(AdvertisementSeeder::class);
        $this->call(BrandSeeder::class);

        $this->call(ProductSeeder::class);
        $this->call(ProductImageSeeder::class);
        $this->call(QuestionAnswerSeeder::class);

        $this->call(ProductInventorySeeder::class);
        $this->call(ShoppingSessionSeeder::class);
        $this->call(CartItemSeeder::class);
        $this->call(OrderDetailSeeder::class);
        $this->call(OrderItemSeeder::class);

        $this->call(ProductRatingSeeder::class);
        $this->call(WishlistSeeder::class);

        $this->call(EmailSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(PageLinkSeeder::class);
    }
}
