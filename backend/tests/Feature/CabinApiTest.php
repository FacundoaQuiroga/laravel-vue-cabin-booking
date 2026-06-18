<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cabin;

class CabinApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_cabins(): void {
        Cabin::create([
            'name' => 'Arrayan Cabin',
            'capacity' => 2,
            'description' => 'small cabin for couples.',
            'status' => 'available',
        ]);

        $response = $this->getJson('/api/cabins');
        $response->assertOk();

        $response->assertJsonFragment([
            'name' => 'Arrayan Cabin',
        ]);
    }

    public function test_can_update_cabins(): void {

        $cabin = Cabin::create([
            'name' => 'Coihue Cabin',
            'capacity' => 3,
            'description' => 'same description',
            'status' => 'available',
        ]);

        $response = $this->putJson('/api/cabins/' . $cabin->id, [
            'name' => 'HArrayan Cabin',
            'capacity' => 5,
            'description' => 'another description',
            'status' => 'unavailable',
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('cabins', [
            'id' => $cabin->id,
            'name' => 'HArrayan Cabin',
            'capacity' => 5,
            'description' => 'another description',
            'status' => 'unavailable',
        ]);

    }

    public function test_can_delete_cabins(): void {
        
        $cabin = Cabin::create([
            'name' => 'Lenga Cabin',
            'capacity' => 3,
            'description' => 'same description',
            'status' => 'available',
        ]);

        $response = $this->deleteJson('/api/cabins/' . $cabin->id);

        $response->assertOk();

        $this->assertDatabaseMissing('cabins', [
            'id' => $cabin->id,
        ]);
    }


    public function test_cabin_requires_valid_data(): void {

        $response = $this->postJson('/api/cabins', [
            'name' => '',
            'capacity' => 0,
            'description' => null,
            'status' => 'invalid-status',
        ]);


        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'name',
            'capacity',
            'status',
        ]);

        $this->assertDatabaseCount('cabins', 0);

    }

    
}
