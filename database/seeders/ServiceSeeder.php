<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            [
                'name' => 'Reguler',
                'price' => 300000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Eksklusif',
                'price' => 600000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
