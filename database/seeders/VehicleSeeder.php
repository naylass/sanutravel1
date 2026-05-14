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
                'driver_id' => 1,
                'plate_number' => 'A 1234 ABC',
                'brand' => 'Ertiga',
                'type' => 'MPV',
                'capacity' => 4,
            ],
            [
                'driver_id' => 2,
                'plate_number' => 'A 5678 DEF',
                'brand' => 'Avanza',
                'type' => 'MPV',
                'capacity' => 4,
            ],
            [
                'driver_id' => 3,
                'plate_number' => 'A 9012 GHI',
                'brand' => 'Inova',
                'type' => 'MPV',
                'capacity' => 5,
            ],
            [
                'driver_id' => 4,
                'plate_number' => 'A 3456 JKL',
                'brand' => 'Xpander',
                'type' => 'MPV',
                'capacity' => 5,
            ],
            [
                'driver_id' => '5',
                'plate_number' => 'A 7890 MNO',
                'brand' => 'Xenia',
                'type' => 'MPV',
                'capacity' => 6,
            ],
        ]);
    }
}
