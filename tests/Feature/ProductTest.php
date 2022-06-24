<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_get_all_product_without_logging_in()
    {
        $response = $this->get('/api/allProduct');
        $response->assertStatus(200);
    }

    public function test_get_one_product_without_logging_in()
    {
        $response = $this->get("/api/oneProduct/1");
        $response->assertStatus(200);
    }

    public function test_store_a_single_product()
    {
        $superAdmin = User::factory()->create(['role' => 1]);
        $admin = User::factory()->create(['role' => 2]);
        $client = User::factory()->create(['role' => 3]);

        // $user = WithFaker::factory(User::class)->create();
        $product = Product::factory()->create();

        $response = $this
            ->post("/api/product", $product->toArray());
        $response->assertStatus(302);

        $response = $this
            ->actingAs($superAdmin)->post("/api/product", $product->toArray());
        $response->assertStatus(200);


        $response = $this
            ->actingAs($admin)->post("/api/product", $product->toArray());
        $response->assertStatus(200);


        $response = $this
            ->actingAs($client)->post("/api/product", $product->toArray());
        $response->assertStatus(302);
        // gets redirection response code
    }

    public function test_update_a_product()
    {
        $product = Product::factory()->create();
        $newData = Product::factory()->create();


        $superAdmin = User::factory()->create(['role' => 1]);
        $admin = User::factory()->create(['role' => 2]);
        $client = User::factory()->create(['role' => 3]);

        $response = $this
            ->put("/api/product/" . $product->id, $newData->toArray());
        $response->assertStatus(302);

        $response = $this
            ->actingAs($superAdmin)->put("/api/product/" . $product->id, $newData->toArray());
        $response->assertStatus(200);

        $response = $this
            ->actingAs($admin)->put("/api/product/" . $product->id, $newData->toArray());
        $response->assertStatus(200);

        $response = $this
            ->actingAs($client)->put("/api/product/" . $product->id, $newData->toArray());
        $response->assertStatus(302);
    }

    public function test_delete_a_product()
    {
        $product = Product::factory()->create();
        $superAdmin = User::factory()->create(['role' => 1]);

        $response = $this
            ->delete("/api/product/" . $product->id);
        $response->assertStatus(302);

        $response = $this
            ->actingAs($superAdmin)->delete("/api/product/" . $product->id);
        $response->assertStatus(200);

        $product = Product::factory()->create();
        $admin = User::factory()->create(['role' => 2]);
        $response = $this
            ->actingAs($admin)->delete("/api/product/" . $product->id);
        $response->assertStatus(200);

        $product = Product::factory()->create();
        $client = User::factory()->create(['role' => 3]);
        $response = $this
            ->actingAs($client)->delete("/api/product/" . $product->id);
        $response->assertStatus(302);
    }
}
