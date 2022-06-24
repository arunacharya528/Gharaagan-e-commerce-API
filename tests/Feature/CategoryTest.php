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
    public function test_get_all_categories_without_logging_in()
    {
        $response = $this->get('/api/allCategory');
        $response->assertStatus(200);
    }

    public function test_post_a_category()
    {
        $superAdmin = User::factory()->create(['role' => 1]);
        $admin = User::factory()->create(['role' => 2]);
        $client = User::factory()->create(['role' => 3]);

        $category = ProductCategory::factory()->create(['is_parent' => true]);

        $response = $this
            ->post("/api/productCategory", $category->toArray());
        $response->assertStatus(302);

        $response = $this
            ->actingAs($superAdmin)->post("/api/productCategory", $category->toArray());
        $response->assertStatus(200);

        $response = $this
            ->actingAs($admin)->post("/api/productCategory", $category->toArray());
        $response->assertStatus(200);

        $response = $this
            ->actingAs($client)->post("/api/productCategory", $category->toArray());
        $response->assertStatus(302);
    }

    public function test_update_a_category()
    {
        $superAdmin = User::factory()->create(['role' => 1]);
        $admin = User::factory()->create(['role' => 2]);
        $client = User::factory()->create(['role' => 3]);

        $category = ProductCategory::factory()->create(['is_parent' => true]);

        $response = $this
            ->put("/api/productCategory/" . $category->id, $category->toArray());
        $response->assertStatus(302);

        $response = $this
            ->actingAs($superAdmin)->put("/api/productCategory/" . $category->id, $category->toArray());
        $response->assertStatus(200);

        $response = $this
            ->actingAs($admin)->put("/api/productCategory/" . $category->id, $category->toArray());
        $response->assertStatus(200);

        $response = $this
            ->actingAs($client)->put("/api/productCategory/" . $category->id, $category->toArray());
        $response->assertStatus(302);
    }

    public function test_delete_a_category()
    {
        $category = ProductCategory::factory()->create(['is_parent' => true]);
        $response = $this
            ->delete("/api/productCategory/" . $category->id);
        $response->assertStatus(302);

        $superAdmin = User::factory()->create(['role' => 1]);
        $category = ProductCategory::factory()->create(['is_parent' => true]);
        $response = $this
            ->actingAs($superAdmin)->delete("/api/productCategory/" . $category->id);
        $response->assertStatus(200);

        $admin = User::factory()->create(['role' => 2]);
        $category = ProductCategory::factory()->create(['is_parent' => true]);
        $response = $this
            ->actingAs($admin)->delete("/api/productCategory/" . $category->id);
        $response->assertStatus(200);

        $client = User::factory()->create(['role' => 3]);
        $category = ProductCategory::factory()->create(['is_parent' => true]);
        $response = $this
            ->actingAs($client)->delete("/api/productCategory/" . $category->id);
        $response->assertStatus(302);
    }
}
