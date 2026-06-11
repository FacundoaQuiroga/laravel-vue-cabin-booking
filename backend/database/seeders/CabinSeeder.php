<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cabin;

class CabinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Cabin::create([
            'name' => 'Cabin A',
            'capacity' => 2,
            'description' => 'Small cabin for couples.',
            'status' => 'available',
        ]);

        Cabin::create([
            'name' => 'Cabin B',
            'capacity' => 4,
            'description' => 'Family cabin with mountain view.',
            'status' => 'available',
        ]);

        Cabin::create([
            'name' => 'Cabin C',
            'capacity' => 6,
            'description' => 'Large cabin for groups.',
            'status' => 'available',
        ]);
        
    }
}
