<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShoppingSessionTest extends TestCase
{
    public function test_get_all_without_logging_in()
    {
        $response = $this->get('/api/shoppingSession');
        $response->assertStatus(302);
    }

    public function test_get_all_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/shoppingSession');
        $response->assertStatus(302);
    }

    public function test_get_all_deny_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->get('/api/shoppingSession');
        $response->assertStatus(302);
    }

    public function test_get_all_as_superadmin(){
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->get('/api/shoppingSession');
        $response->assertStatus(200);
    }
}
