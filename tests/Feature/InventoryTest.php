<?php

namespace Tests\Feature;

use App\Models\ProductInventory;
use App\Models\User;
use Dflydev\DotAccessData\Data;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_deny_without_loggin_in()
    {
        $response = $this->get('/api/productInventory');
        $response->assertStatus(302);
    }

    public function test_get_all_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/productInventory');
        $response->assertStatus(302);
    }

    public function test_get_all_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->get('/api/productInventory');
        $response->assertStatus(200);
    }

    public function test_get_all_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->get('/api/productInventory');
        $response->assertStatus(200);
    }

    public function test_post_deny_without_logging_in()
    {
        $data = ProductInventory::factory()->create();
        $response = $this->post("/api/productInventory", $data->toArray());
        $response->assertStatus(302);
    }

    public function test_post_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $data = ProductInventory::factory()->create();
        $response = $this->actingAs($user)->post("/api/productInventory", $data->toArray());
        $response->assertStatus(302);
    }

    public function test_post_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $data = ProductInventory::factory()->create();
        $response = $this->actingAs($user)->post("/api/productInventory", $data->toArray());
        $response->assertStatus(200);
    }

    public function test_post_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $data = ProductInventory::factory()->create();
        $response = $this->actingAs($user)->post("/api/productInventory", $data->toArray());
        $response->assertStatus(200);
    }

    public function test_put_deny_without_logging_in()
    {
        $data = ProductInventory::factory()->create();
        $response = $this->put("/api/productInventory/" . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $data = ProductInventory::factory()->create();
        $response = $this->actingAs($user)->put("/api/productInventory/" . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $data = ProductInventory::factory()->create();
        $response = $this->actingAs($user)->put("/api/productInventory/" . $data->id, $data->toArray());
        $response->assertStatus(200);
    }

    public function test_put_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $data = ProductInventory::factory()->create();
        $response = $this->actingAs($user)->put("/api/productInventory/" . $data->id, $data->toArray());
        $response->assertStatus(200);
    }

    public function test_delete_deny_without_logging_in()
    {
        $data = ProductInventory::factory()->create();
        $response = $this->delete("/api/productInventory/" . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $data = ProductInventory::factory()->create();
        $response = $this->actingAs($user)->delete("/api/productInventory/" . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $data = ProductInventory::factory()->create();
        $response = $this->actingAs($user)->delete("/api/productInventory/" . $data->id);
        $response->assertStatus(200);
    }

    public function test_delete_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $data = ProductInventory::factory()->create();
        $response = $this->actingAs($user)->delete("/api/productInventory/" . $data->id);
        $response->assertStatus(200);
    }
}
