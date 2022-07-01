<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductImageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_image_related_to_product_deny_without_logging_in()
    {
        $product = Product::factory()->create();
        ProductImage::factory(3)->create(['product_id' => $product->id]);
        $response = $this->get('/api/productImage?product_id=' . $product->id);
        $response->assertStatus(302);
    }

    public function test_get_image_related_to_product_deny_as_client()
    {
        $product = Product::factory()->create();
        ProductImage::factory(3)->create(['product_id' => $product->id]);
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->get('/api/productImage?product_id=' . $product->id);
        $response->assertStatus(302);
    }

    public function test_get_image_related_to_product_as_admin()
    {
        $product = Product::factory()->create();
        ProductImage::factory(3)->create(['product_id' => $product->id]);
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->get('/api/productImage?product_id=' . $product->id);
        $response->assertStatus(200);
    }

    public function test_get_image_related_to_product_as_superadmin()
    {
        $product = Product::factory()->create();
        ProductImage::factory(3)->create(['product_id' => $product->id]);
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->get('/api/productImage?product_id=' . $product->id);
        $response->assertStatus(200);
    }

    public function test_get_all_as_authorized()
    {
        ProductImage::factory(3)->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->get('/api/productImage');
        $response->assertStatus(200);
    }

    public function test_post_deny_without_logging_in()
    {
        $data = ProductImage::factory()->create();
        $response = $this->post('/api/productImage', $data->toArray());
        $response->assertStatus(302);
    }

    public function test_post_deny_as_client()
    {
        $data = ProductImage::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->post('/api/productImage', $data->toArray());
        $response->assertStatus(302);
    }


    public function test_post_as_admin()
    {
        $data = ProductImage::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->post('/api/productImage', $data->toArray());
        $response->assertStatus(200);
    }

    public function test_post_as_superadmin()
    {
        $data = ProductImage::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->post('/api/productImage', $data->toArray());
        $response->assertStatus(200);
    }

    public function test_delete_deny_without_logging_in(){
        $data = ProductImage::factory()->create();
        $response = $this->delete('/api/productImage/'. $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_deny_as_client()
    {
        $data = ProductImage::factory()->create();
        $user = User::factory()->create(['role' => 3]);
        $response = $this->actingAs($user)->delete('/api/productImage/' . $data->id);
        $response->assertStatus(302);
    }

    public function test_delete_as_admin()
    {
        $data = ProductImage::factory()->create();
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->delete('/api/productImage/' . $data->id);
        $response->assertStatus(200);
    }

    public function test_delete_as_superadmin()
    {
        $data = ProductImage::factory()->create();
        $user = User::factory()->create(['role' => 1]);
        $response = $this->actingAs($user)->delete('/api/productImage/' . $data->id);
        $response->assertStatus(200);
    }
}
