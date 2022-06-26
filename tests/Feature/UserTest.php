<?php

namespace Tests\Feature;

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_get_all_deny_without_logging_in()
    {
        $response = $this->get('/api/user');
        $response->assertStatus(302);
    }

    public function test_get_all_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/user');
        $response->assertStatus(302);
    }

    public function test_get_all_deny_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->get('/api/user');
        $response->assertStatus(302);
    }

    public function test_get_all_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->get('/api/user');
        $response->assertStatus(200);
    }

    public function test_get_one_deny_without_logging_in()
    {
        $user = User::factory()->create(['role' => 1]);
        $response = $this->get('/api/user/' . $user->id);
        $response->assertStatus(302);
    }

    public function test_get_one_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/user/' . $user->id);
        $response->assertStatus(302);
    }

    public function test_get_one_deny_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->get('/api/user/' . $user->id);
        $response->assertStatus(302);
    }

    public function test_get_one_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->get('/api/user/' . $user->id);
        $response->assertStatus(200);
    }

    public function test_post_deny_without_logging_in()
    {
        $user = User::factory()->create(['role' => 1]);
        $response = $this->post('/api/user', $user->toArray());
        $response->assertStatus(302);
    }

    public function test_post_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->post('/api/user', $user->toArray());
        $response->assertStatus(302);
    }

    public function test_post_deny_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->post('/api/user', $user->toArray());
        $response->assertStatus(302);
    }

    public function test_post_as_superadmin()
    {
        $faker = Factory::create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->post('/api/user', [
            'email' => $faker->email(),
            'password' => 'password',
            'name' => $faker->name(),
            'contact' => $faker->phoneNumber(),
            'role' => 2
        ]);
        $response->assertStatus(200);
    }

    public function test_delete_deny_without_logging_in()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->delete('/api/user/' . $user->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->delete('/api/user/' . $user->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->delete('/api/user/' . $user->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_superadmin_delete_own_account()
    {
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->delete('/api/user/' . $user->id);
        $response->assertStatus(302);
    }

    public function test_delete_as_superadmin_delete_other_account()
    {
        $data = User::factory()->create(['role' => 2]);
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->delete('/api/user/' . $data->id);
        $response->assertStatus(200);
    }
}
