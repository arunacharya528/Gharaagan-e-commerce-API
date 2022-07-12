<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\ShoppingSession;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartItemTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_post_deny_without_logging_in()
    {
        $data = CartItem::factory()->create();
        $response = $this->post('/api/cartItem', $data->toArray());
        $response->assertStatus(302);
    }

    public function test_post_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $session = ShoppingSession::factory()->create(['user_id' => $user->id]);
        $data = CartItem::factory()->create(['session_id' => $session->id]);
        $response = $this->actingAs($user)->post('/api/cartItem', $data->toArray());
        $response->assertStatus(200);
    }

    public function test_post_deny_as_admin()
    {
        $data = CartItem::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->post('/api/cartItem', $data->toArray());
        $response->assertStatus(302);
    }

    public function test_post_deny_as_superadmin()
    {
        $data = CartItem::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->post('/api/cartItem', $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_without_logging_in()
    {
        $data = CartItem::factory()->create();
        $response = $this->put('/api/cartItem/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_as_unauthorized_client()
    {
        $user = User::factory()->create(['role' => 3]);
        ShoppingSession::factory()->create(['user_id' => $user->id]);

        $newUser = User::factory()->create(['role' => 3]);
        $session = ShoppingSession::factory()->create(['user_id' => $newUser->id]);
        $data = CartItem::factory()->create(['session_id' => $session->id]);

        $response = $this->actingAs($user)->put('/api/cartItem/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_as_authorized_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $session = ShoppingSession::factory()->create(['user_id' => $user->id]);
        $data = CartItem::factory()->create(['session_id' => $session->id]);

        $response = $this->actingAs($user)->put('/api/cartItem/' . $data->id, $data->toArray());
        $response->assertStatus(200);
    }

    public function test_put_deny_as_admin()
    {
        $data = CartItem::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->put('/api/cartItem/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_as_superadmin()
    {
        $data = CartItem::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->put('/api/cartItem/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_delete_deny_without_logging_in()
    {
        $data = CartItem::factory()->create();
        $response = $this->delete('/api/cartItem/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_unauthorized_client()
    {
        $user = User::factory()->create(['role' => 3]);
        ShoppingSession::factory()->create(['user_id' => $user->id]);

        $newUser = User::factory()->create(['role' => 3]);
        $session = ShoppingSession::factory()->create(['user_id' => $newUser->id]);
        $data = CartItem::factory()->create(['session_id' => $session->id]);

        $response = $this->actingAs($user)->delete('/api/cartItem/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_as_suthorized_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $session = ShoppingSession::factory()->create(['user_id' => $user->id]);
        $data = CartItem::factory()->create(['session_id' => $session->id]);

        $response = $this->actingAs($user)->delete('/api/cartItem/' . $data->id);
        $response->assertStatus(200);
    }

    public function test_delete_deny_as_admin()
    {
        $data = CartItem::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->delete('/api/cartItem/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_as_superadmin()
    {
        $data = CartItem::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->delete('/api/cartItem/' . $data->id);
        $response->assertStatus(200);
    }
}
