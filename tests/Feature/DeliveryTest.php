<?php

namespace Tests\Feature;

use App\Models\Delivery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeliveryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_deny_without_logging_in()
    {
        $response = $this->get('/api/delivery');
        $response->assertStatus(302);
    }

    public function test_get_all_as_auth_user()
    {
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->get('/api/delivery');
        $response->assertStatus(200);
    }

    public function test_post_deny_without_loggin_in()
    {
        $data = Delivery::factory()->create();
        $response = $this->post('/api/delivery', $data->toArray());
        $response->assertStatus(302);
    }

    public function test_post_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $data = Delivery::factory()->create();
        $response = $this->actingAs($user)->post('/api/delivery', $data->toArray());
        $response->assertStatus(302);
    }

    public function test_post_deny_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $data = Delivery::factory()->create();
        $response = $this->actingAs($user)->post('/api/delivery', $data->toArray());
        $response->assertStatus(302);
    }

    public function test_post_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $data = Delivery::factory()->create();
        $response = $this->actingAs($user)->post('/api/delivery', $data->toArray());
        $response->assertStatus(200);
    }

    public function test_put_deny_without_logging_in()
    {
        $data = Delivery::factory()->create();
        $response = $this->put('/api/delivery/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $data = Delivery::factory()->create();
        $response = $this->actingAs($user)->put('/api/delivery/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $data = Delivery::factory()->create();
        $response = $this->actingAs($user)->put('/api/delivery/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $data = Delivery::factory()->create();
        $response = $this->actingAs($user)->put('/api/delivery/' . $data->id, $data->toArray());
        $response->assertStatus(200);
    }

    public function test_delete_deny_without_logging_in()
    {
        $data = Delivery::factory()->create();
        $response = $this->delete('/api/delivery/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $data = Delivery::factory()->create();
        $response = $this->actingAs($user)->delete('/api/delivery/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $data = Delivery::factory()->create();
        $response = $this->actingAs($user)->delete('/api/delivery/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $data = Delivery::factory()->create();
        $response = $this->actingAs($user)->delete('/api/delivery/' . $data->id);
        $response->assertStatus(200);
    }
}
