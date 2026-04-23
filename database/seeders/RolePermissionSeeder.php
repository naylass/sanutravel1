<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        //kode ini buat nambah role akun
        $roles = [
            'superadmin',
            'admin',
            'driver',
            'customer',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
        //kode ini buat nambah permission
        $permissions = [
            'manage.users',
            'manage.drivers',
            'manage.services',
            'manage.vehicles',
            'manage.schedules',
            'manage.bookings',
            'manage.deliveryorders',
            'manage.payments',
            'manage.incomes',
            'manage.notifications',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        //kode ini buat ngasih permission ke akun
        Role::findByName('superadmin')
            ->givePermissionTo(Permission::all());

        Role::findByName('admin')
            ->givePermissionTo([
                'manage.users',
                'manage.drivers',
                'manage.services',
                'manage.vehicles',
                'manage.schedules',
                'manage.bookings',
                'manage.deliveryorders',
                'manage.payments',
                'manage.incomes',
                'manage.notifications',
            ]);

        Role::findByName('driver')
            ->givePermissionTo([
                'manage.deliveryorders',
            ]);

        Role::findByName('customer')
            ->givePermissionTo([
                'manage.bookings',
                'manage.payments',
            ]);
    }
}
