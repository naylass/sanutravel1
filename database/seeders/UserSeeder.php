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

        $users = [
            [
                'name' => 'Superadmin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'superadmin',
            ],
            [
                'name' => 'Admin',
                'email' => 'nylaadjah@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Syahnuri',
                'email' => 'Syahnuri@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'driver',
            ],
            [
                'name' => 'Atika',
                'email' => 'atika@gmail.com',
                'password' => Hash::make('atika123'),
                'role' => 'customer',
            ],
            [
                'name' => 'Anjeng',
                'email' => 'naylajk101@gmail.com',
                'password' => Hash::make('anjeng123'),
                'role' => 'customer',
            ],
            [
                'name' => 'Nazwa',
                'email' => 'nylsjdh18@gmail.com',
                'password' => Hash::make('nazwa123'),
                'role' => 'customer',
            ],
        ];

        foreach ($users as $data) {
            $users = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => $data['password'],
                ],
            );

            if (!$users->hasRole($data['role'])) {

                $users->assignRole($data['role']);
            }
        }
    }
}