<?php

namespace Tests\Feature;

use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderDetailTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_deny_without_logging_in()
    {
        $response = $this->get('/api/orderDetail');
        $response->assertStatus(302);
    }

    public function test_get_all_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/orderDetail');
        $response->assertStatus(302);
    }

    public function test_get_all_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->get('/api/orderDetail');
        $response->assertStatus(200);
    }

    public function test_get_all_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->get('/api/orderDetail');
        $response->assertStatus(200);
    }

    public function test_put_deny_without_logging_in()
    {
        $data = OrderDetail::factory()->create();
        $response = $this->put('/api/orderDetail/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_deny_as_client()
    {
        $data = OrderDetail::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->put('/api/orderDetail/' . $data->id, $data->toArray());
        $response->assertStatus(302);
    }

    public function test_put_as_admin()
    {
        $data = OrderDetail::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->put('/api/orderDetail/' . $data->id, $data->toArray());
        $response->assertStatus(200);
    }

    public function test_put_as_superadmin()
    {
        $data = OrderDetail::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->put('/api/orderDetail/' . $data->id, $data->toArray());
        $response->assertStatus(200);
    }

    public function test_delete_deny_without_logging_in()
    {
        $data = OrderDetail::factory()->create();
        $response = $this->delete('/api/orderDetail/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_client()
    {
        $data = OrderDetail::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->delete('/api/orderDetail/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_as_admin()
    {
        $data = OrderDetail::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->delete('/api/orderDetail/' . $data->id);
        $response->assertStatus(200);
    }

    public function test_delete_as_superadmin()
    {
        $data = OrderDetail::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->delete('/api/orderDetail/' . $data->id);
        $response->assertStatus(200);
    }

    public function test_cancel_without_loggin_in(){

    }
}
