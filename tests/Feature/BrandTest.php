<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_brands_without_logging_in()
    {
        $response = $this->get('/api/allBrand');
        $response->assertStatus(200);
    }

    public function test_get_a_single_brand_without_logging_in()
    {
        $brand = Brand::factory()->create();
        $response = $this->get('/api/oneBrand/' . $brand->id);
        $response->assertStatus(200);
    }

    public function test_post_a_brand()
    {
        $brand = Brand::factory()->create();

        $superAdmin = User::factory()->create(['role' => 1]);
        $admin = User::factory()->create(['role' => 2]);
        $client = User::factory()->create(['role' => 3]);

        $response = $this
            ->post("/api/brand", $brand->toArray());
        $response->assertStatus(302);

        $response = $this
            ->actingAs($superAdmin)->post("/api/brand", $brand->toArray());
        $response->assertStatus(200);

        $response = $this
            ->actingAs($admin)->post("/api/brand", $brand->toArray());
        $response->assertStatus(200);

        $response = $this
            ->actingAs($client)->post("/api/brand", $brand->toArray());
        $response->assertStatus(302);
    }

    public function test_update_a_brand()
    {
        $brand = Brand::factory()->create();

        $superAdmin = User::factory()->create(['role' => 1]);
        $admin = User::factory()->create(['role' => 2]);
        $client = User::factory()->create(['role' => 3]);

        $response = $this
            ->put("/api/brand/" . $brand->id, $brand->toArray());
        $response->assertStatus(302);

        $response = $this
            ->actingAs($superAdmin)->put("/api/brand/" . $brand->id, $brand->toArray());
        $response->assertStatus(200);

        $response = $this
            ->actingAs($admin)->put("/api/brand/" . $brand->id, $brand->toArray());
        $response->assertStatus(200);

        $response = $this
            ->actingAs($client)->put("/api/brand/" . $brand->id, $brand->toArray());
        $response->assertStatus(302);
    }

    public function test_delete_a_brand()
    {
        $brand = Brand::factory()->create();
        $response = $this
            ->delete("/api/brand/" . $brand->id);
        $response->assertStatus(302);

        $brand = Brand::factory()->create();
        $superAdmin = User::factory()->create(['role' => 1]);
        $response = $this
            ->actingAs($superAdmin)->delete("/api/brand/" . $brand->id);
        $response->assertStatus(200);

        $brand = Brand::factory()->create();
        $admin = User::factory()->create(['role' => 2]);
        $response = $this
            ->actingAs($admin)->delete("/api/brand/" . $brand->id);
        $response->assertStatus(200);

        $brand = Brand::factory()->create();
        $client = User::factory()->create(['role' => 3]);
        $response = $this
            ->actingAs($client)->delete("/api/brand/" . $brand->id);
        $response->assertStatus(302);
    }
}
