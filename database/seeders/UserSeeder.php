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
                'email' => 'nylasjdh@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'driver',
            ],
            [
                'name' => 'Suhada',
                'email' => 'nizaraufar1611@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'driver',
            ],
            [
                'name' => 'Defri',
                'email' => 'defri123@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'driver',
            ],
            [
                'name' => 'Danang',
                'email' => 'danang123@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'driver',
            ],
            [
                'name' => 'Ujang',
                'email' => 'ujang123@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'driver',
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
