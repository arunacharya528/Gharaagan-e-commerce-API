<?php

namespace Tests\Feature;

use App\Models\Email;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmailTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register_email_for_newsletter()
    {
        $response = $this->post('/api/newsletter/conditionalSubscribe', ['email' => 'test@email.com']);
        $response->assertStatus(200);
    }

    public function test_unregister_email_for_newsletter()
    {
        $email = Email::factory()->create();
        $response = $this->post('/api/newsletter/conditionalSubscribe', ['email' => $email->email]);
        $response->assertStatus(200);
    }

    public function test_get_all_without_logging_in()
    {
        $response = $this->get("/api/newsletter");
        $response->assertStatus(302);
    }

    public function test_get_all_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get("/api/newsletter");
        $response->assertStatus(302);
    }

    public function test_get_all_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->get("/api/newsletter");
        $response->assertStatus(200);
    }

    public function test_get_all_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->get("/api/newsletter");
        $response->assertStatus(200);
    }
}
