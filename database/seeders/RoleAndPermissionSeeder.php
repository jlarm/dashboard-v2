<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);

        Permission::create(['name' => 'create-dealerships']);
        Permission::create(['name' => 'edit-dealerships']);
        Permission::create(['name' => 'delete-dealerships']);

        Permission::create(['name' => 'create-stores']);
        Permission::create(['name' => 'edit-stores']);
        Permission::create(['name' => 'delete-stores']);

        Role::create(['name' => 'super-admin']);

        $adminRole = Role::create(['name' => 'Admin']);
        $consultantRole = Role::create(['name' => 'Consultant']);
        $ownerRole = Role::create(['name' => 'Owner']);
        $gmRole = Role::create(['name' => 'GM']);
        $cfoRole = Role::create(['name' => 'CFO']);
        $gsmRole = Role::create(['name' => 'GSM']);
        $managerRole = Role::create(['name' => 'Manager']);
        $employeeRole = Role::create(['name' => 'Employee']);

        $adminRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',
            'create-dealerships',
            'edit-dealerships',
            'delete-dealerships',
            'create-stores',
            'edit-stores',
            'delete-stores',
        ]);

        $consultantRole->givePermissionTo([
            'create-users',
            'edit-users',
            'create-dealerships',
            'edit-dealerships',
            'create-stores',
            'edit-stores',
        ]);

        $ownerRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',
            'create-stores',
            'edit-stores',
            'delete-stores',
        ]);

        $gmRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',
            'create-stores',
            'edit-stores',
            'delete-stores',
        ]);

        $cfoRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',
            'create-stores',
            'edit-stores',
            'delete-stores',
        ]);

        $gsmRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',
            'create-stores',
            'edit-stores',
            'delete-stores',
        ]);

        $managerRole->givePermissionTo([
            'create-users',
            'edit-users',
        ]);

        $employeeRole->givePermissionTo([

        ]);
    }
}
