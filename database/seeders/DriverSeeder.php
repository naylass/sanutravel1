<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('drivers')->insert([
            [
                'name' => 'Supriyadi',
                'phone' => '089011220099',
                'birth_place' => 'Cilegon',
                'birth_date' => '2000-03-20',
                'gender' => 'male',
                'address' => 'Jl. Cilegon',
                'medical_history' => 'Asma',
                'license_number' => '123456789012345',
            ],
            [
                'name' => 'Yanto',
                'phone' => '089011220091',
                'birth_place' => 'Cilegon',
                'birth_date' => '1998-03-20',
                'gender' => 'male',
                'address' => 'Jl. Cilegon',
                'medical_history' => 'Asma',
                'license_number' => '123456789112345',
            ],
            [
                'name' => 'Egi',
                'phone' => '089011220092',
                'birth_place' => 'Cilegon',
                'birth_date' => '2003-03-20',
                'gender' => 'male',
                'address' => 'Jl. Cilegon',
                'medical_history' => 'Asma',
                'license_number' => '123456789212345',
            ],
            [
                'name' => 'Ambar',
                'phone' => '089011220099',
                'birth_place' => 'Cilegon',
                'birth_date' => '2005-03-20',
                'gender' => 'female',
                'address' => 'Jl. Cilegon',
                'medical_history' => 'Asma',
                'license_number' => '123456789312345',
            ],
            [
                'name' => 'Nayla',
                'phone' => '089011220094',
                'birth_place' => 'Cilegon',
                'birth_date' => '2003-03-20',
                'gender' => 'female',
                'address' => 'Jl. Cilegon',
                'medical_history' => 'Asma',
                'license_number' => '123456789312345',
            ],
        ]);
    }
}
