<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    // use RefreshDatabase;
    use WithFaker;

    public function testCanListProducts()
    {
        // Crie 5 produtos de exemplo no banco de dados
        Product::factory(5)->create();

        $response = $this->get('/api/v1/products');

        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'price',
                        'photo'
                    ]
                ]
            ]);

        // Teste a próxima página (se houver)
        if ($response->json('next_page_url')) {
            $nextPageResponse = $this->get($response->json('next_page_url'));

            $nextPageResponse->assertStatus(200);
            $nextPageResponse->assertJsonFragment([
                'current_page' => 2, // Página atual deve ser 2
            ]);
        }
    }


    public function testCanShowProduct()
    {
        $product = Product::factory()->create();

        $response = $this->get("/api/v1/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'price',
                'photo'
            ]);

        // Verifique as propriedades do produto
        $response->assertJson([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'photo' => $product->photo
        ]);
    }

    public function testCanCreateProduct()
    {
        $data = [
            'name' => fake()->jobTitle(),
            'price' => fake()->randomFloat(2, 1, 100),
            'photo' => fake()->imageUrl()
        ];

        $response = $this->post('/api/v1/products', $data);

        $response->assertStatus(201)
            ->assertJsonStructure(['id']);
    }

    public function testCanUpdateProduct()
    {
        $product = Product::factory()->create();

        $data = [
            'name' => fake()->jobTitle(),
            'price' => fake()->randomFloat(2, 1, 100),
            'photo' => fake()->imageUrl()
        ];

        $response = $this->put("/api/v1/products/{$product->id}", $data);

        $response->assertStatus(200)
            ->assertJsonStructure(['id']);
    }

    public function testCanDeleteProduct()
    {
        $product = Product::factory()->create();

        $response = $this->delete("/api/v1/products/{$product->id}");

        $response->assertStatus(204);
    }
}
