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
                'name' => 'Suhada',
                'phone' => '089011220099',
                'email' => 'nizaraufar1611@gmail.com',
                'birth_place' => 'Cilegon',
                'birth_date' => '1988-04-20',
                'gender' => 'male',
                'address' => 'Jl. Cilegon',
                'medical_history' => 'Asma',
                'license_number' => '123456789012345',
            ],
            [
                'name' => 'Syahnuri',
                'phone' => '089011220091',
                'email' => 'nylasjdh@gmail.com',
                'birth_place' => 'Cilegon',
                'birth_date' => '1980-12-12',
                'gender' => 'male',
                'address' => 'Jl. Cilegon',
                'medical_history' => 'Asma',
                'license_number' => '123456789112345',
            ],
            [
                'name' => 'Defri',
                'phone' => '089011220092',
                'email' => 'defri123@gmail.com',
                'birth_place' => 'Cilegon',
                'birth_date' => '1985-05-20',
                'gender' => 'male',
                'address' => 'Jl. Cilegon',
                'medical_history' => 'Asma',
                'license_number' => '123456789212345',
            ],
            [
                'name' => 'Danang',
                'phone' => '089011220099',
                'email' => 'danang123@gmail.com',
                'birth_place' => 'Cilegon',
                'birth_date' => '1975-06-20',
                'gender' => 'male',
                'address' => 'Jl. Cilegon',
                'medical_history' => 'Asma',
                'license_number' => '123456789312345',
            ],
            [
                'name' => 'Ujang',
                'phone' => '089011220094',
                'email' => 'ujang123@gmail.com',
                'birth_place' => 'Cilegon',
                'birth_date' => '1980-03-20',
                'gender' => 'male',
                'address' => 'Jl. Cilegon',
                'medical_history' => 'Asma',
                'license_number' => '123456789312345',
            ],
        ]);
    }
}
