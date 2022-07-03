<?php

namespace Tests\Feature;

use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdvertisementTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_active_advertisements_without_logging_in()
    {
        $response = $this->get('/api/activeAds');
        $response->assertStatus(200);
    }

    public function test_get_all_deny_without_logging_in()
    {
        $response = $this->get('/api/advertisement');
        $response->assertStatus(302);
    }

    public function test_get_all_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/advertisement');
        $response->assertStatus(302);
    }

    public function test_get_all_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->get('/api/advertisement');
        $response->assertStatus(200);
    }

    public function test_get_all_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->get('/api/advertisement');
        $response->assertStatus(200);
    }

    public function test_post_deny_without_logging_in()
    {
        $data = Advertisement::factory()->create();
        $response = $this->post('/api/advertisement', $data->toArray());
        $response->assertStatus(302);
    }

    public function test_post_deny_as_client()
    {
        $data = Advertisement::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->post('/api/advertisement', $data->toArray());
        $response->assertStatus(302);
    }

    public function test_post_as_superadmin()
    {
        $data = Advertisement::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->post('/api/advertisement', $data->toArray());
        $response->assertStatus(200);
    }

    public function test_post_as_admin()
    {
        $data = Advertisement::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->post('/api/advertisement', $data->toArray());
        $response->assertStatus(200);
    }

    public function test_put_deny_without_logging_in()
    {
        $data = Advertisement::factory()->create();
        $response = $this->put('/api/advertisement/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_as_client()
    {
        $data = Advertisement::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->put('/api/advertisement/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_as_superadmin()
    {
        $data = Advertisement::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->put('/api/advertisement/' . $data->id, $data->toArray());
        $response->assertStatus(200);
    }

    public function test_put_as_admin()
    {
        $data = Advertisement::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->put('/api/advertisement/' . $data->id, $data->toArray());
        $response->assertStatus(200);
    }

    public function test_delete_deny_without_logging_in()
    {
        $data = Advertisement::factory()->create();
        $response = $this->delete('/api/advertisement/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_client()
    {
        $data = Advertisement::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->delete('/api/advertisement/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_as_superadmin()
    {
        $data = Advertisement::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->delete('/api/advertisement/' . $data->id);
        $response->assertStatus(200);
    }

    public function test_delete_as_admin()
    {
        $data = Advertisement::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->delete('/api/advertisement/' . $data->id);
        $response->assertStatus(200);
    }
}
