<?php

namespace Tests\Feature;

use App\Models\Courier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourierApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_paginated_couriers_sorted_by_name_by_default()
    {
        Courier::factory()->create(['name' => 'Candra']);
        Courier::factory()->create(['name' => 'Agus']);
        Courier::factory()->create(['name' => 'Budi']);

        $response = $this->getJson('/api/couriers');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'current_page', 'total']);
            
        $this->assertEquals('Agus', $response->json('data.0.name'));
    }

    public function test_can_filter_couriers_by_search_query()
    {
        Courier::factory()->create(['name' => 'Budiono Hadi Agung']);
        Courier::factory()->create(['name' => 'Siti Aminah']);

        $response = $this->getJson('/api/couriers?search=budi+agung');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
        $this->assertEquals('Budiono Hadi Agung', $response->json('data.0.name'));
    }

    public function test_can_filter_couriers_by_multiple_levels()
    {
        Courier::factory()->create(['name' => 'Courier Lvl 1', 'level' => 1]);
        Courier::factory()->create(['name' => 'Courier Lvl 2', 'level' => 2]);
        Courier::factory()->create(['name' => 'Courier Lvl 3', 'level' => 3]);

        $response = $this->getJson('/api/couriers?level=2,3');

        $response->assertStatus(200);
        $this->assertCount(2, $response->json('data'));
    }

    public function test_can_create_courier_with_validation()
    {
        $payload = [
            'name' => 'John Doe',
            'phone_number' => '08123456789',
            'vehicle_type' => 'Motorcycle',
            'level' => 3
        ];

        $response = $this->postJson('/api/couriers', $payload);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'John Doe');

        $this->assertDatabaseHas('couriers', ['phone_number' => '08123456789']);
    }

    public function test_cannot_create_courier_with_invalid_level()
    {
        $payload = [
            'name' => 'John Doe',
            'phone_number' => '08123456789',
            'vehicle_type' => 'Motorcycle',
            'level' => 6
        ];

        $response = $this->postJson('/api/couriers', $payload);
        $response->assertStatus(422);
    }

    public function test_can_show_specific_courier()
    {
        $courier = Courier::factory()->create();

        $response = $this->getJson("/api/couriers/{$courier->id}");

        $response->assertStatus(200)
            ->assertJsonPath('id', $courier->id);
    }

    public function test_can_update_courier_data()
    {
        $courier = Courier::factory()->create(['name' => 'Old Name']);

        $response = $this->putJson("/api/couriers/{$courier->id}", [
            'name' => 'New Name'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('couriers', [
            'id' => $courier->id,
            'name' => 'New Name'
        ]);
    }

    public function test_can_delete_courier_and_removed_from_database()
    {
        $courier = Courier::factory()->create();

        $response = $this->deleteJson("/api/couriers/{$courier->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('couriers', ['id' => $courier->id]);
    }
}