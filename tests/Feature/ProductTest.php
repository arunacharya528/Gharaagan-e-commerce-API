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
    public function test_get_all_without_logging_in()
    {
        $response = $this->get('/api/allProduct');
        $response->assertStatus(200);
    }

    public function test_get_one_without_logging_in()
    {
        $response = $this->get("/api/oneProduct/1");
        $response->assertStatus(200);
    }

    public function test_post_deny_without_logging_in()
    {
        $product = Product::factory()->create();
        $response = $this
            ->post("/api/product", $product->toArray());
        $response->assertStatus(302);
    }

    public function test_post_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $product = Product::factory()->create();
        $response = $this
            ->actingAs($user)->post("/api/product", $product->toArray());
        $response->assertStatus(302);
    }

    public function test_post_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $product = Product::factory()->create();
        $response = $this
            ->actingAs($user)->post("/api/product", $product->toArray());
        $response->assertStatus(200);
    }

    public function test_post_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $product = Product::factory()->create();
        $response = $this
            ->actingAs($user)->post("/api/product", $product->toArray());
        $response->assertStatus(200);
    }


    public function test_put_deny_without_logging_in()
    {
        $product = Product::factory()->create();
        $newData = Product::factory()->create();
        $response = $this
            ->put("/api/product/" . $product->id, $newData->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_updating_as_client()
    {
        $product = Product::factory()->create();
        $newData = Product::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this
            ->actingAs($user)->put("/api/product/" . $product->id, $newData->toArray());
        $response->assertStatus(302);
    }

    public function test_put_as_superadmin()
    {
        $product = Product::factory()->create();
        $newData = Product::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this
            ->actingAs($user)->put("/api/product/" . $product->id, $newData->toArray());
        $response->assertStatus(200);
    }

    public function test_put_as_admin()
    {
        $product = Product::factory()->create();
        $newData = Product::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this
            ->actingAs($user)->put("/api/product/" . $product->id, $newData->toArray());
        $response->assertStatus(200);
    }

    public function test_delete_deny_without_logging_in()
    {
        $product = Product::factory()->create();
        $response = $this
            ->delete("/api/product/" . $product->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_client()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this
            ->actingAs($user)->delete("/api/product/" . $product->id);
        $response->assertStatus(302);
    }

    public function test_delete_as_superadmin()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this
            ->actingAs($user)->delete("/api/product/" . $product->id);
        $response->assertStatus(200);
    }

    public function test_delete_as_admin()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this
            ->actingAs($user)->delete("/api/product/" . $product->id);
        $response->assertStatus(200);
    }
}
