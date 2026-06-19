<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cabin;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class CabinApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());
    }

    public function test_can_list_cabins(): void {
        Cabin::factory()->create([
            'name' => 'Arrayan Cabin',
        ]);

        $response = $this->getJson('/api/cabins');
        $response->assertOk();

        $response->assertJsonFragment([
            'name' => 'Arrayan Cabin',
        ]);
    }

    public function test_can_create_cabin(): void {

        $response = $this->postJson('/api/cabins', [
            'name' => 'Coihue Cabin',
            'capacity' => 4,
            'description' => 'Family cabin with mountain view.',
            'status' => 'available',
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('cabins', [
            'name' => 'Coihue Cabin',
            'capacity' => 4,
            'status' => 'available',
        ]);
    }

    public function test_can_update_cabins(): void {

        $cabin = Cabin::factory()->create();

        $response = $this->putJson('/api/cabins/' . $cabin->id, [
            'name' => 'Arrayan Cabin Updated',
            'capacity' => 5,
            'description' => 'another description',
            'status' => 'unavailable',
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('cabins', [
            'id' => $cabin->id,
            'name' => 'Arrayan Cabin Updated',
            'capacity' => 5,
            'description' => 'another description',
            'status' => 'unavailable',
        ]);

    }

    public function test_can_delete_cabins(): void {
        
        $cabin = Cabin::factory()->create();

        $response = $this->deleteJson('/api/cabins/' . $cabin->id);

        $response->assertOk();

        $this->assertSoftDeleted('cabins', [
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
