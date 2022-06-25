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
    public function test_get_all_without_logging_in()
    {
        $response = $this->get('/api/allBrand');
        $response->assertStatus(200);
    }

    public function test_get_one_without_logging_in()
    {
        $brand = Brand::factory()->create();
        $response = $this->get('/api/oneBrand/' . $brand->id);
        $response->assertStatus(200);
    }

    public function test_post_deny_without_logging_in()
    {
        $brand = Brand::factory()->create();
        $response = $this
            ->post("/api/brand", $brand->toArray());
        $response->assertStatus(302);
    }

    public function test_post_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $brand = Brand::factory()->create();
        $response = $this
            ->actingAs($user)->post("/api/brand", $brand->toArray());
        $response->assertStatus(302);
    }

    public function test_post_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $brand = Brand::factory()->create();
        $response = $this
            ->actingAs($user)->post("/api/brand", $brand->toArray());
        $response->assertStatus(200);
    }

    public function test_post_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $brand = Brand::factory()->create();
        $response = $this
            ->actingAs($user)->post("/api/brand", $brand->toArray());
        $response->assertStatus(200);
    }

    public function test_put_deny_without_logging_in()
    {
        $brand = Brand::factory()->create();
        $response = $this
            ->put("/api/brand/" . $brand->id, $brand->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_as_client()
    {
        $brand = Brand::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this
            ->actingAs($user)->put("/api/brand/" . $brand->id, $brand->toArray());
        $response->assertStatus(302);
    }

    public function test_put_as_superadmin()
    {
        $brand = Brand::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this
            ->actingAs($user)->put("/api/brand/" . $brand->id, $brand->toArray());
        $response->assertStatus(200);
    }

    public function test_put_as_admin()
    {
        $brand = Brand::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this
            ->actingAs($user)->put("/api/brand/" . $brand->id, $brand->toArray());
        $response->assertStatus(200);
    }

    public function test_delete_deny_without_logging_in()
    {
        $brand = Brand::factory()->create();
        $response = $this
            ->delete("/api/brand/" . $brand->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_client()
    {
        $brand = Brand::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this
            ->actingAs($user)->delete("/api/brand/" . $brand->id);
        $response->assertStatus(302);
    }

    public function test_delete_as_superadmin()
    {
        $brand = Brand::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this
            ->actingAs($user)->delete("/api/brand/" . $brand->id);
        $response->assertStatus(200);
    }

    public function test_delete_as_admin()
    {
        $brand = Brand::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this
            ->actingAs($user)->delete("/api/brand/" . $brand->id);
        $response->assertStatus(200);
    }
}
