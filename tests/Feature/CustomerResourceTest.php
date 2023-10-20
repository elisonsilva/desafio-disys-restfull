<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Foundation\Testing\WithFaker;

class CustomerResourceTest extends TestCase
{
    // use RefreshDatabase;
    use WithFaker;

    public function testCanListCustomers()
    {
        Customer::factory()->count(30)->create();

        $response = $this->get('/api/v1/customers');

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'birthdate',
                        'phone',
                        'address',
                        'complement',
                        'neighborhood',
                        'zipcode',
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

    public function testCanShowCustomer()
    {
        $customer = Customer::factory()->create();

        $response = $this->get("/api/v1/customers/{$customer->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'birthdate',
            'phone',
            'address',
            'complement',
            'neighborhood',
            'zipcode',
            'created_at'
        ]);
        $response->assertJson([
            'id' => $customer->id,
            'name' => $customer->name,
            'email' => $customer->email,
            'birthdate' => $customer->birthdate,
            'phone' => $customer->phone,
            'address' => $customer->address,
            'complement' => $customer->complement,
            'neighborhood' => $customer->neighborhood,
            'zipcode' => $customer->zipcode,
            'created_at' => $customer->created_at->toISOString(),
        ]);
    }

    public function testCanCreateCustomer()
    {
        $data = [
            'name' => 'Ewald Raynor ' . fake()->word(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'birthdate' => fake()->date(),
            'address' => fake()->address(),
            'complement' => fake()->jobTitle(),
            'neighborhood' => fake()->word(),
            'zipcode' => fake()->postcode(),
        ];

        $response = $this->post('/api/v1/customers', $data);

        $response->assertStatus(201);
        $response->assertJsonStructure(['id']);
    }

    public function testCanUpdateCustomer()
    {
        $customer = Customer::factory()->create();

        $data = [
            'name' => 'Eliza Quitzon',
        ];

        $response = $this->put("/api/v1/customers/{$customer->id}", $data);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id']);
    }

    public function testCanDeleteCustomer()
    {
        $customer = Customer::factory()->create();
        $response = $this->delete("/api/v1/customers/{$customer->id}");
        $response->assertStatus(204);
    }
}
