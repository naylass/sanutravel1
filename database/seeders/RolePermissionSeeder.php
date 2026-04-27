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
            'create.users',
            'edit.users',

            'manage.drivers',
            'create.drivers',
            'edit.drivers',
            'delete.drivers',

            'manage.services',
            'edit.services',

            'manage.vehicles',
            'create.vehicles',
            'edit.vehicles',
            'delete.vehicles',

            'manage.schedules',
            'create.schedules',
            'edit.schedules',
            'delete.schedules',
            'cancel.schedule',

            'manage.bookings',
            'edit.bookings',
            'delete.bookings',
            'cancel.booking',

            'manage.deliveryorders',
            'create.deliveryorders',

            'manage.payments',
            'create.payments',
            'edit.payments',

            'manage.incomes',
            'create.incomes',
            'edit.incomes',
            'delete.incomes',
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
