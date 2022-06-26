<?php

namespace Tests\Feature;

use App\Models\Discount;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DiscountTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_deny_without_logging_in()
    {
        $response = $this->get('/api/discount');
        $response->assertStatus(302);
    }

    public function test_get_all_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/discount');
        $response->assertStatus(302);
    }

    public function test_get_all_as_sueradmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->get('/api/discount');
        $response->assertStatus(200);
    }

    public function test_get_all_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->get('/api/discount');
        $response->assertStatus(200);
    }

    public function test_get_discount_by_name_without_logging_in()
    {
        $data = Discount::factory()->create();
        $response = $this->get('/api/discount/' . $data->name . "/find");
        $response->assertStatus(302);
    }

    public function test_get_discount_by_name_by_logging_in()
    {
        $data = Discount::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/discount/' . $data->name . "/find");
        $response->assertStatus(200);
    }

    public function test_post_deny_without_logging_in()
    {
        $data = Discount::factory()->create();
        $response = $this->post('/api/discount', $data->toArray());
        $response->assertStatus(302);
    }

    public function test_post_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $data = Discount::factory()->create();
        $response = $this->actingAs($user)->post('/api/discount', $data->toArray());
        $response->assertStatus(302);
    }

    public function test_post_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $data = Discount::factory()->create();
        $response = $this->actingAs($user)->post('/api/discount', $data->toArray());
        $response->assertStatus(200);
    }

    public function test_post_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $data = Discount::factory()->create();
        $response = $this->actingAs($user)->post('/api/discount', $data->toArray());
        $response->assertStatus(200);
    }

    public function test_put_deny_without_logging_in()
    {
        $data = Discount::factory()->create();
        $response = $this->put('/api/discount/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $data = Discount::factory()->create();
        $response = $this->actingAs($user)->put('/api/discount/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $data = Discount::factory()->create();
        $response = $this->actingAs($user)->put('/api/discount/' . $data->id, $data->toArray());
        $response->assertStatus(200);
    }

    public function test_put_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $data = Discount::factory()->create();
        $response = $this->actingAs($user)->put('/api/discount/' . $data->id, $data->toArray());
        $response->assertStatus(200);
    }

    public function test_delete_deny_without_logging_in()
    {
        $data = Discount::factory()->create();
        $response = $this->delete("/api/discount/" . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $data = Discount::factory()->create();
        $response = $this->actingAs($user)->delete("/api/discount/" . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $data = Discount::factory()->create();
        $response = $this->actingAs($user)->delete("/api/discount/" . $data->id);
        $response->assertStatus(200);
    }

    public function test_delete_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $data = Discount::factory()->create();
        $response = $this->actingAs($user)->delete("/api/discount/" . $data->id);
        $response->assertStatus(200);
    }
}
