<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_page_by_slug_without_logging_in()
    {
        $page = Page::factory()->create();
        $response = $this->get('/api/page/bySlug/' . $page->slug);
        $response->assertStatus(200);
    }

    public function test_get_all_deny_without_logging_in()
    {
        $response = $this->get('/api/page');
        $response->assertStatus(302);
    }

    public function test_get_all_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/page');
        $response->assertStatus(302);
    }

    public function test_get_all_deny_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->get('/api/page');
        $response->assertStatus(302);
    }

    public function test_get_all_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->get('/api/page');
        $response->assertStatus(200);
    }

    public function test_get_one_deny_without_logging_in()
    {
        $page = Page::factory()->create();
        $response = $this->get('/api/page/' . $page->id);
        $response->assertStatus(302);
    }

    public function test_get_one_deny_as_client()
    {
        $page = Page::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/page/' . $page->id);
        $response->assertStatus(302);
    }

    public function test_get_one_deny_as_admin()
    {
        $page = Page::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->get('/api/page/' . $page->id);
        $response->assertStatus(302);
    }

    public function test_get_one_as_superadmin()
    {
        $page = Page::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->get('/api/page/' . $page->id);
        $response->assertStatus(200);
    }

    public function test_post_deny_without_logging_in()
    {
        $page = Page::factory()->create();
        $response = $this->post('/api/page', $page->toArray());
        $response->assertStatus(302);
    }

    public function test_post_deny_as_client()
    {
        $page = Page::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->post('/api/page', $page->toArray());
        $response->assertStatus(302);
    }


    public function test_post_deny_as_admin()
    {
        $page = Page::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->post('/api/page', $page->toArray());
        $response->assertStatus(302);
    }


    public function test_post_as_superadmin()
    {
        $page = Page::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->post('/api/page', $page->toArray());
        $response->assertStatus(200);
    }

    public function test_put_deny_without_logging_in()
    {
        $page = Page::factory()->create();
        $response = $this->put('/api/page/' . $page->id, $page->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_as_client()
    {
        $page = Page::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->put('/api/page/' . $page->id, $page->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_as_admin()
    {
        $page = Page::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->put('/api/page/' . $page->id, $page->toArray());
        $response->assertStatus(302);
    }

    public function test_put_as_superAdmin()
    {
        $page = Page::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->put('/api/page/' . $page->id, $page->toArray());
        $response->assertStatus(200);
    }

    public function test_delete_deny_without_logging_in()
    {
        $page = Page::factory()->create();
        $response = $this->delete('/api/page/' . $page->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_client()
    {
        $page = Page::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->delete('/api/page/' . $page->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_admin()
    {
        $page = Page::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->delete('/api/page/' . $page->id);
        $response->assertStatus(302);
    }

    public function test_delete_as_superadmin()
    {
        $page = Page::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->delete('/api/page/' . $page->id);
        $response->assertStatus(200);
    }
}
