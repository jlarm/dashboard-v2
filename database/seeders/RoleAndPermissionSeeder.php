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

        Permission::create(['name' => 'create-vendors']);
        Permission::create(['name' => 'edit-vendors']);
        Permission::create(['name' => 'delete-vendors']);

        Role::create(['global_id' => 'super-admin', 'name' => 'super-admin']);

        $adminRole = Role::create(['global_id' => 'Admin','name' => 'Admin']);
        $consultantRole = Role::create(['global_id' => 'Consultant','name' => 'Consultant']);
        $ownerRole = Role::create(['global_id' => 'Owner','name' => 'Owner']);
        $qiRole = Role::create(['global_id' => 'QI','name' => 'Qualified Individual']);
        $gmRole = Role::create(['global_id' => 'GM','name' => 'GM']);
        $cfoRole = Role::create(['global_id' => 'CFO','name' => 'CFO']);
        $gsmRole = Role::create(['global_id' => 'GSM','name' => 'GSM']);
        $managerRole = Role::create(['global_id' => 'Manager','name' => 'Manager']);
        $employeeRole = Role::create(['global_id' => 'Employee','name' => 'Employee']);

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
            'create-vendors',
            'edit-vendors',
            'delete-vendors',
        ]);

        $consultantRole->givePermissionTo([
            'create-users',
            'edit-users',
            'create-dealerships',
            'edit-dealerships',
            'create-stores',
            'edit-stores',
            'create-vendors',
            'edit-vendors',
            'delete-vendors',
        ]);

        $ownerRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',
            'create-stores',
            'edit-stores',
            'delete-stores',
            'create-vendors',
            'edit-vendors',
            'delete-vendors',
        ]);

        $qiRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',
            'create-stores',
            'edit-stores',
            'delete-stores',
            'create-vendors',
            'edit-vendors',
            'delete-vendors',
        ]);

        $gmRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',
            'create-stores',
            'edit-stores',
            'delete-stores',
            'create-vendors',
            'edit-vendors',
            'delete-vendors',
        ]);

        $cfoRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',
            'create-stores',
            'edit-stores',
            'delete-stores',
            'create-vendors',
            'edit-vendors',
            'delete-vendors',
        ]);

        $gsmRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',
            'create-stores',
            'edit-stores',
            'delete-stores',
            'create-vendors',
            'edit-vendors',
            'delete-vendors',
        ]);

        $managerRole->givePermissionTo([
            'create-users',
            'edit-users',
        ]);

        $employeeRole->givePermissionTo([

        ]);
    }
}
