<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehicles')->insert([
            [
                'driver_id' => 3,
                'plate_number' => 'A 1234 ABC',
                'brand' => 'Toyota',
                'type' => 'Avanza',
                'capacity' => 4,
            ],
            [
                'driver_id' => 4,
                'plate_number' => 'A 5678 DEF',
                'brand' => 'Honda',
                'type' => 'Civic',
                'capacity' => 4,
            ],
            [
                'driver_id' => 5,
                'plate_number' => 'A 9012 GHI',
                'brand' => 'Mitsubishi',
                'type' => 'Outlander',
                'capacity' => 5,
            ],
            [
                'driver_id' => 1,
                'plate_number' => 'A 3456 JKL',
                'brand' => 'Nissan',
                'type' => 'Sentra',
                'capacity' => 5,
            ],
            [
                'driver_id' => '2',
                'plate_number' => 'A 7890 MNO',
                'brand' => 'Hyundai',
                'type' => 'Elantra',
                'capacity' => 6,
            ],
        ]);
    }
}
