<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_deny_without_logging_in()
    {
        $response = $this->get('/api/file');
        $response->assertStatus(302);
    }

    public function test_get_all_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/file');
        $response->assertStatus(302);
    }

    public function test_get_all_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->get('/api/file');
        $response->assertStatus(200);
    }

    public function test_get_all_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->get('/api/file');
        $response->assertStatus(200);
    }

    public function test_post_deny_without_logging_in()
    {
        $response = $this->post('/api/file', [
            'file' => UploadedFile::fake()->image('demo.jpg'),
            'name' => 'random name'
        ]);
        $response->assertStatus(302);
    }

    public function test_post_deny_as_client()
    {
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->post('/api/file', [
            'file' => UploadedFile::fake()->image('demo.jpg'),
            'name' => 'random name'
        ]);
        $response->assertStatus(302);
    }

    public function test_post_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->post('/api/file', [
            'file' => UploadedFile::fake()->image('demo.jpg'),
            'name' => 'random name'
        ]);
        $response->assertStatus(200);
        Storage::disk('public')->assertExists($response['path']);
    }

    public function test_post_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->post('/api/file', [
            'file' => UploadedFile::fake()->image('demo.jpg'),
            'name' => 'random name'
        ]);
        $response->assertStatus(200);
        Storage::disk('public')->assertExists($response['path']);
    }

    public function test_delete_as_admin()
    {
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->post('/api/file', [
            'file' => UploadedFile::fake()->image('demo.jpg'),
            'name' => 'random name'
        ]);
        $response = $this->actingAs($user)->delete('/api/file/' . $response['id']);
        $response->assertStatus(200);
    }

    public function test_delete_as_superadmin()
    {
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->post('/api/file', [
            'file' => UploadedFile::fake()->image('demo.jpg'),
            'name' => 'random name'
        ]);
        $response = $this->actingAs($user)->delete('/api/file/' . $response['id']);
        $response->assertStatus(200);
    }
}
