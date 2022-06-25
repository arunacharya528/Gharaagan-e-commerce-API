<?php

namespace Tests\Feature;

use App\Models\SiteDetail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SiteDetailTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_without_logging_in()
    {
        $response = $this->get('/api/allSiteDetail');
        $response->assertStatus(200);
    }

    public function test_put_deny_without_logging_in()
    {
        $data = SiteDetail::factory()->create();
        $response = $this->put('/api/siteDetail/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_as_client()
    {
        $data = SiteDetail::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->put('/api/siteDetail/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_as_admin()
    {
        $data = SiteDetail::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->put('/api/siteDetail/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_as_superadmin()
    {
        $data = SiteDetail::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->put('/api/siteDetail/' . $data->id, $data->toArray());
        $response->assertStatus(200);
    }
}
