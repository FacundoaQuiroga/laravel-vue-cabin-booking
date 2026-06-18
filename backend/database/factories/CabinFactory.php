<?php

namespace Database\Factories;

use App\Models\Cabin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cabin>
 */
class CabinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Arrayan Cabin',
                'Coihue Cabin',
                'Lenga Cabin',
                'Maqui Cabin',
            ]),
            'capacity' => fake()->numberBetween(2, 6),
            'description' => fake()->sentence(),
            'status' => 'available',
        ];
    }
}
