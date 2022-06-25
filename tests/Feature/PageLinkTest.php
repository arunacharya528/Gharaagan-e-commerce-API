<?php

namespace Tests\Feature;

use App\Models\PageLink;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PageLinkTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_without_logging_in()
    {
        $response = $this->get('/api/allPageLinks');
        $response->assertStatus(200);
    }

    public function test_post_deny_without_logging_in()
    {
        $data = PageLink::factory()->create();
        $response = $this->post('/api/pageLink', $data->toArray());
        $response->assertStatus(302);
    }

    public function test_post_deny_as_client()
    {
        $data = PageLink::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->post('/api/pageLink', $data->toArray());
        $response->assertStatus(302);
    }

    public function test_post_deny_as_admin()
    {
        $data = PageLink::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->post('/api/pageLink', $data->toArray());
        $response->assertStatus(302);
    }

    public function test_post_as_superadmin()
    {
        $data = PageLink::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->post('/api/pageLink', $data->toArray());
        $response->assertStatus(200);
    }

    public function test_put_deny_without_logging_in()
    {
        $data = PageLink::factory()->create();
        $response = $this->put('/api/pageLink/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_as_client()
    {
        $data = PageLink::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->put('/api/pageLink/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }
    public function test_put_deny_as_admin()
    {
        $data = PageLink::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->put('/api/pageLink/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_as_superadmin()
    {
        $data = PageLink::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->put('/api/pageLink/' . $data->id, $data->toArray());
        $response->assertStatus(200);
    }
    public function delete_deny_without_logging_in()
    {
        $data = PageLink::factory()->create();
        $response = $this->delete('/api/pageLink/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_client()
    {
        $data = PageLink::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->delete('/api/pageLink/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_admin()
    {
        $data = PageLink::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->delete('/api/pageLink/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_as_admin()
    {
        $data = PageLink::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->delete('/api/pageLink/' . $data->id);
        $response->assertStatus(200);
    }
}
