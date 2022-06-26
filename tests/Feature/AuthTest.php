<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Discount;
use App\Models\ShoppingSession;
use App\Models\User;
use App\Models\UserAddress;
use Facade\Ignition\Support\FakeComposer;
use Faker\Factory;
use FontLib\Table\Type\name;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_regiser()
    {
        $faker = Factory::create();
        $response = $this->post("/api/register", [
            'name' => $faker->name(),
            'email' => $faker->email(),
            'password' => 'password',
            'contact' => $faker->phoneNumber()
        ]);
        $response->assertStatus(200);
    }

    public function test_register_deny_without_data()
    {
        $response = $this->post("/api/register");
        $response->assertStatus(400);
    }

    public function test_login()
    {
        $user = User::factory()->create();
        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $response->assertStatus(200);
    }

    public function test_deny_login_random_detail()
    {
        $response = $this->post('/api/login', [
            'email' => 'random@random.com',
            'password' => 'password'
        ]);
        $response->assertStatus(401);
    }

    public function test_deny_login_no_data()
    {
        $response = $this->post('/api/login');
        $response->assertStatus(401);
    }

    public function test_logout_without_logging_in()
    {
        $response = $this->get('/api/logout');
        $response->assertStatus(302);
    }

    public function test_logout_by_logging_in()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->get('/api/logout');
        $response->assertStatus(200);
    }

    public function test_get_deny_without_logging_in()
    {
        $response = $this->get('/api/user/session');
        $response->assertStatus(302);
    }

    public function test_get_deny_other_than_client()
    {
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->get('/api/user/session');
        $response->assertStatus(302);
    }

    public function test_get_session()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/user/session');
        $response->assertStatus(200);
    }

    public function test_get_orders()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/user/orders');
        $response->assertStatus(200);
    }

    public function test_get_ratings()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/user/ratings');
        $response->assertStatus(200);
    }

    public function test_get_question_answers()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/user/questionAnswers');
        $response->assertStatus(200);
    }

    public function test_get_addresses()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/user/addresses');
        $response->assertStatus(200);
    }

    public function test_get_wishlist()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/user/wishlist');
        $response->assertStatus(200);
    }

    public function test_post_checkout()
    {
        $user = User::factory()->create(['role' => 3]);
        $session = ShoppingSession::factory()->create(['user_id' => $user->id]);
        CartItem::factory(4)->create(['session_id' => $session->id]);


        $response = $this->actingAs($user)->post('/api/user/checkout', [
            'address_id' => UserAddress::factory()->create()->id,
            'discount_id' => Discount::factory()->create()->id
        ]);

        $response->assertStatus(200);
    }
}
