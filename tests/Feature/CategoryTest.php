<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_without_logging_in()
    {
        $response = $this->get('/api/allCategory');
        $response->assertStatus(200);
    }

    public function test_post_deny_without_logging_in()
    {
        $category = ProductCategory::factory()->create(['is_parent' => true]);
        $response = $this
            ->post("/api/productCategory", $category->toArray());
        $response->assertStatus(302);
    }

    public function test_post_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $category = ProductCategory::factory()->create(['is_parent' => true]);
        $response = $this
            ->actingAs($user)->post("/api/productCategory", $category->toArray());
        $response->assertStatus(302);
    }

    public function test_post_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $category = ProductCategory::factory()->create(['is_parent' => true]);
        $response = $this
            ->actingAs($user)->post("/api/productCategory", $category->toArray());
        $response->assertStatus(200);
    }

    public function test_post_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $category = ProductCategory::factory()->create(['is_parent' => true]);
        $response = $this
            ->actingAs($user)->post("/api/productCategory", $category->toArray());
        $response->assertStatus(200);
    }

    public function test_put_deny_without_logging_in()
    {
        $category = ProductCategory::factory()->create(['is_parent' => true]);
        $response = $this
            ->put("/api/productCategory/" . $category->id, $category->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $category = ProductCategory::factory()->create(['is_parent' => true]);
        $response = $this
            ->actingAs($user)->put("/api/productCategory/" . $category->id, $category->toArray());
        $response->assertStatus(302);
    }

    public function test_put_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $category = ProductCategory::factory()->create(['is_parent' => true]);
        $response = $this
            ->actingAs($user)->put("/api/productCategory/" . $category->id, $category->toArray());
        $response->assertStatus(200);
    }

    public function test_put_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $category = ProductCategory::factory()->create(['is_parent' => true]);
        $response = $this
            ->actingAs($user)->put("/api/productCategory/" . $category->id, $category->toArray());
        $response->assertStatus(200);
    }

    public function test_delete_deny_without_logging_in()
    {
        $category = ProductCategory::factory()->create(['is_parent' => true]);
        $response = $this
            ->delete("/api/productCategory/" . $category->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $category = ProductCategory::factory()->create(['is_parent' => true]);
        $response = $this
            ->actingAs($user)->delete("/api/productCategory/" . $category->id);
        $response->assertStatus(302);
    }

    public function test_delete_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $category = ProductCategory::factory()->create(['is_parent' => true]);
        $response = $this
            ->actingAs($user)->delete("/api/productCategory/" . $category->id);
        $response->assertStatus(200);
    }


    public function test_delete_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $category = ProductCategory::factory()->create(['is_parent' => true]);
        $response = $this
            ->actingAs($user)->delete("/api/productCategory/" . $category->id);
        $response->assertStatus(200);
    }

}
