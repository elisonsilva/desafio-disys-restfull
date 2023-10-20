<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    // use RefreshDatabase;
    use WithFaker;

    public function testCanListOrders()
    {
        // Crie 5 pedidos de exemplo no banco de dados
        Order::factory(5)->create();

        $response = $this->get('/api/v1/orders');

        $response->assertStatus(200)
        ->assertJsonStructure(['data'])
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'customer_id',
                        'product_id',
                        'created_at'
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


    public function testCanShowOrder()
    {
        $order = Order::factory()->create();

        $response = $this->get("/api/v1/orders/{$order->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'customer_id',
                'product_id',
                'created_at'
            ]);

        // Verifique as propriedades do pedido
        $response->assertJson([
            'id' => $order->id,
            'customer_id' => $order->customer_id,
            'product_id' => $order->product_id,
            'created_at' => $order->created_at->toISOString(),
        ]);
    }

    public function testCanCreateOrder()
    {
        $data = [
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'product_id' => Product::inRandomOrder()->first()->id,
        ];

        $response = $this->post('/api/v1/orders', $data);

        $response->assertStatus(201)
            ->assertJsonStructure(['id']);
    }

    public function testCanDeleteOrder()
    {
        $order = Order::factory()->create();

        $response = $this->delete("/api/v1/orders/{$order->id}");

        $response->assertStatus(204);
    }
}
