<?php

namespace Tests\Feature;

use App\Models\ProductRating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductRatingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_deny_without_logging_in()
    {
        $response = $this->get('/api/productRating');
        $response->assertStatus(302);
    }

    public function test_get_all_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/productRating');
        $response->assertStatus(302);
    }

    public function test_get_all_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->get('/api/productRating');
        $response->assertStatus(200);
    }

    public function test_get_all_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->get('/api/productRating');
        $response->assertStatus(200);
    }

    public function test_delete_deny_without_logging_in()
    {
        $data = ProductRating::factory()->create();
        $response = $this->delete('/api/productRating/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $data = ProductRating::factory()->create();
        $response = $this->actingAs($user)->delete('/api/productRating/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $data = ProductRating::factory()->create();
        $response = $this->actingAs($user)->delete('/api/productRating/' . $data->id);
        $response->assertStatus(200);
    }

    public function test_delete_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $data = ProductRating::factory()->create();
        $response = $this->actingAs($user)->delete('/api/productRating/' . $data->id);
        $response->assertStatus(200);
    }
}
