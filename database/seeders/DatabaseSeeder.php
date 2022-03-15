<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\CartItem;
use App\Models\Discount;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductInventory;
use App\Models\ShoppingSession;
use App\Models\User;
use App\Models\UserAddress;
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
        // \App\Models\User::factory(10)->create();

        ProductCategory::factory(30)->create();
        ProductInventory::factory(30)->create();
        Discount::factory(10)->create();
        Product::factory(30)->create();
        User::factory(10)->create();

        UserAddress::factory(20)->create();
        ShoppingSession::factory(30)->create();
        CartItem::factory(30)->create();
        OrderDetail::factory(30)->create();
        OrderItem::factory(30)->create();

        Banner::factory(20)->create();
        ProductImage::factory(50)->create();
    }
}
