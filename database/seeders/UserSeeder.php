<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'naysaj@gmail.com',
                'password' => Hash::make('admin123'),
            ],
            [
                'name' => 'Syahnuri',
                'email' => 'Syahnuri@gmail.com',
                'password' => Hash::make('admin123'),
            ],
        ]);
    }
}
