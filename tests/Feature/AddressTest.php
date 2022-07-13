<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_post_deny_without_logging_in()
    {
        $data = UserAddress::factory()->create();
        $response = $this->post('/api/userAddress', $data->toArray());
        $response->assertStatus(302);
    }

    public function test_post_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $data = UserAddress::factory()->create();
        $response = $this->actingAs($user)->post('/api/userAddress', $data->toArray());
        $response->assertStatus(200);
    }


    public function test_post_deny_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $data = UserAddress::factory()->create();
        $response = $this->actingAs($user)->post('/api/userAddress', $data->toArray());
        $response->assertStatus(302);
    }


    public function test_post_deny_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $data = UserAddress::factory()->create();
        $response = $this->actingAs($user)->post('/api/userAddress', $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_without_logging_in()
    {
        $user = User::factory()->create(['role' => 1]);
        $data = UserAddress::factory()->create();
        $response = $this->actingAs($user)->put('/api/userAddress/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_as_unauthorized_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $newUser = User::factory()->create(['role' => 3]);
        $data = UserAddress::factory()->create(['user_id' => $newUser->id]);
        $response = $this->actingAs($user)->put('/api/userAddress/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_as_authorized_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $data = UserAddress::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->put('/api/userAddress/' . $data->id, $data->toArray());
        $response->assertStatus(200);
    }

    public function test_put_deny_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $data = UserAddress::factory()->create();
        $response = $this->actingAs($user)->put('/api/userAddress/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $data = UserAddress::factory()->create();
        $response = $this->actingAs($user)->put('/api/userAddress/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_delete_deny_without_logging_in()
    {
        $data = UserAddress::factory()->create();
        $response = $this->delete('/api/userAddress/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_unauthorized_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $newUser = User::factory()->create(['role' => 3]);
        $data = UserAddress::factory()->create(['user_id' => $newUser->id]);
        $response = $this->actingAs($user)->delete('/api/userAddress/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_as_authorized_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $data = UserAddress::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->delete('/api/userAddress/' . $data->id);
        $response->assertStatus(200);
    }


    public function test_delete_deny_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $data = UserAddress::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->delete('/api/userAddress/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $data = UserAddress::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->delete('/api/userAddress/' . $data->id);
        $response->assertStatus(302);
    }
}
