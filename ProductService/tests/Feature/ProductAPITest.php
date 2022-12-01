<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Product;

class ProductAPITest extends TestCase
{
    use WithFaker;

    function test_get_products_list()
    {
        $productsCount = Product::count();

        $response = $this->get('/api/products');

        $response->assertStatus(200);
        $response->assertExactJson($response->json());

        $this->assertEquals(
            count($response->json('data')),
            $productsCount
        );
    }

    function test_get_single_product()
    {
        $product = Product::first();

        $response = $this->get("/api/products/{$product->id}");

        # assert response.
        $response->assertStatus(200);
        $response->assertExactJson($response->json());
        $this->assertEquals(
            $response->json(),
            [
                'ok' => true,
                'data' => $product->toArray()
            ]
        );
    }

    function test_store_new_product()
    {
        $product = Product::factory()->makeOne();
        $response = $this->post('/api/products', $product->toArray());

        # assert response.
        $response->assertStatus(200);
        $response->assertExactJson($response->json());
        $this->assertTrue($response->json('ok'));

        $insertedProduct = Product::find($response->json('data.id'));
        $this->assertEquals(
            collect($product->toArray())->except('id', 'updated_at'),
            collect($insertedProduct->toArray())->except('id', 'updated_at')
        );
    }

    function test_update_a_product()
    {
        # read product form database.
        $updatingProduct = Product::first();
        $updatingProduct->title = \Str::random(50);
        $updatingProduct->price = rand(100, 500);

        $response = $this->put(
            "/api/products/{$updatingProduct->id}",
            $updatingProduct->toArray()
        );

        # assert response.
        $response->assertStatus(200);
        $response->assertExactJson($response->json());
        $this->assertEquals($response->json(), ['ok' => true]);

        # assert data.
        $updatedProduct = Product::find($updatingProduct->id);
        $this->assertEquals(
            collect($updatingProduct)->except(['updated_at']),
            collect($updatedProduct)->except(['updated_at'])
        );
    }

    function destroy_a_product()
    {
        $product = Product::first();

        $response = $this->delete("/api/products/{$product->id}");

        # assert response.
        $response->assertStatus(200);
        $response->assertExactJson($response->json());
        $this->assertEquals($response->json(), ['ok' => true]);

        # assert db
        $this->assertModelMissing($product);
    }
}
