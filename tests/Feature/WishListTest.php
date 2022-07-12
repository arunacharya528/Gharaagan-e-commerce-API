<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WishListTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function test_post_deny_without_logging_in()
    {
        $data = Wishlist::factory()->create();
        $response = $this->post("/api/wishlist", $data->toArray());
        $response->assertStatus(302);
    }

    public function test_post_as_client()
    {
        $data = Wishlist::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->post("/api/wishlist", $data->toArray());
        $response->assertStatus(200);
    }

    public function test_post_deny_as_admin()
    {
        $data = Wishlist::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->post("/api/wishlist", $data->toArray());
        $response->assertStatus(302);
    }

    public function test_post_deny_as_superadmin()
    {
        $data = Wishlist::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->post("/api/wishlist", $data->toArray());
        $response->assertStatus(302);
    }

    public function test_delete_deny_without_loggin_in()
    {
        $data = Wishlist::factory()->create();
        $response = $this->delete("/api/wishlist/" . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_unauthorized_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $newUser = User::factory()->create(['role' => 3]);
        $data = Wishlist::factory()->create(['user_id' => $newUser->id]);
        $response = $this->actingAs($user)->delete("/api/wishlist/" . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_as_authorized_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $data = Wishlist::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->delete("/api/wishlist/" . $data->id);
        $response->assertStatus(200);
    }

    public function test_delete_deny_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $data = Wishlist::factory()->create();
        $response = $this->actingAs($user)->delete("/api/wishlist/" . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $data = Wishlist::factory()->create();
        $response = $this->actingAs($user)->delete("/api/wishlist/" . $data->id);
        $response->assertStatus(302);
    }
}
