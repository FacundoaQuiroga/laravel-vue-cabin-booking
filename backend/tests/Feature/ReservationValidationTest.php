<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Cabin;

class ReservationValidationTest extends TestCase
{
    use RefreshDatabase;


    public function test_guests_cannot_exceed_cabin_capacity(): void
    {
        $cabin = Cabin::create([
            'name' => 'Cabin A',
            'capacity' => 4,
            'description' => 'Test cabin',
            'status' => 'available',
        ]);

        $response = $this->postJson('/api/reservations', [
            'cabin_id' => $cabin->id,
            'guest_name' => 'Juan Perez',
            'guest_email' => 'juan@example.com',
            'guest_phone' => '+56912345678',
            'check_in' => '2026-07-10',
            'check_out' => '2026-07-12',
            'guests' => 5,
            'status' => 'pending',
            'notes' => null,
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['guests']);

        $this->assertDatabaseMissing('reservations', [
            'guest_email' => 'juan@example.com',
        ]);
    }

    public function test_unavailable_cabin_cannot_be_reserved(): void
    {
        $cabin = Cabin::create([
            'name' => 'Cabin A',
            'capacity' => 4,
            'description' => 'Test cabin',
            'status' => 'unavailable',
        ]);

        $response = $this->postJson('/api/reservations', [
            'cabin_id' => $cabin->id,
            'guest_name' => 'Juan Perez',
            'guest_email' => 'juan@example.com',
            'guest_phone' => '+56912345678',
            'check_in' => '2026-07-10',
            'check_out' => '2026-07-12',
            'guests' => 2,
            'status' => 'pending',
            'notes' => null,
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['cabin_id']);

        $this->assertDatabaseMissing('reservations', [
            'guest_email' => 'juan@example.com',
        ]);
    }

    public function test_cabin_cannot_be_reserved_twice_on_same_dates(): void
    {
        $cabin = Cabin::create([
            'name' => 'Cabin A',
            'capacity' => 4,
            'description' => 'Test cabin',
            'status' => 'available',
        ]);

        $this->postJson('/api/reservations', [
            'cabin_id' => $cabin->id,
            'guest_name' => 'First Guest',
            'guest_email' => 'first@example.com',
            'guest_phone' => '+56911111111',
            'check_in' => '2026-07-10',
            'check_out' => '2026-07-15',
            'guests' => 2,
            'status' => 'confirmed',
            'notes' => null,
        ])->assertStatus(201);

        $response = $this->postJson('/api/reservations', [
            'cabin_id' => $cabin->id,
            'guest_name' => 'Second Guest',
            'guest_email' => 'second@example.com',
            'guest_phone' => '+56922222222',
            'check_in' => '2026-07-12',
            'check_out' => '2026-07-14',
            'guests' => 2,
            'status' => 'pending',
            'notes' => null,
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['check_in', 'check_out']);

        $this->assertDatabaseMissing('reservations', [
            'guest_email' => 'second@example.com',
        ]);
    }


}
