<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'create-dealerships']);
        Permission::firstOrCreate(['name' => 'edit-dealerships']);
        Permission::firstOrCreate(['name' => 'delete-dealerships']);
        Permission::firstOrCreate(['name' => 'view-dealerships']);

        Permission::firstOrCreate(['name' => 'create-stores']);
        Permission::firstOrCreate(['name' => 'edit-stores']);
        Permission::firstOrCreate(['name' => 'delete-stores']);
        Permission::firstOrCreate(['name' => 'view-stores']);

        Permission::firstOrCreate(['name' => 'create-users']);
        Permission::firstOrCreate(['name' => 'edit-users']);
        Permission::firstOrCreate(['name' => 'delete-users']);
        Permission::firstOrCreate(['name' => 'view-users']);

        Permission::firstOrCreate(['name' => 'create-vendors']);
        Permission::firstOrCreate(['name' => 'edit-vendors']);
        Permission::firstOrCreate(['name' => 'delete-vendors']);
        Permission::firstOrCreate(['name' => 'view-vendors']);

        Permission::firstOrCreate(['name' => 'create-scans']);
        Permission::firstOrCreate(['name' => 'edit-scans']);
        Permission::firstOrCreate(['name' => 'delete-scans']);
        Permission::firstOrCreate(['name' => 'view-scans']);

        Permission::firstOrCreate(['name' => 'create-manuals']);
        Permission::firstOrCreate(['name' => 'edit-manuals']);
        Permission::firstOrCreate(['name' => 'delete-manuals']);
        Permission::firstOrCreate(['name' => 'view-manuals']);

        Permission::firstOrCreate(['name' => 'create-audits']);
        Permission::firstOrCreate(['name' => 'edit-audits']);
        Permission::firstOrCreate(['name' => 'delete-audits']);
        Permission::firstOrCreate(['name' => 'view-audits']);

        Role::create(['name' => 'super-admin']);

        $adminRole = Role::create(['name' => 'Admin']);
        $consultantRole = Role::create(['name' => 'Consultant']);
        $ownerRole = Role::create(['name' => 'Owner']);
        $qiRole = Role::create(['name' => 'Qualified Individual']);
        $gmRole = Role::create(['name' => 'GM']);
        $cfoRole = Role::create(['name' => 'CFO']);
        $gsmRole = Role::create(['name' => 'GSM']);
        $managerRole = Role::create(['name' => 'Manager']);
        $employeeRole = Role::create(['name' => 'Employee']);
        $porterDriverRole = Role::create(['name' => 'Porter/Driver']);

        $adminRole->givePermissionTo([
            'create-dealerships',
            'edit-dealerships',
            'delete-dealerships',
            'view-dealerships',
            'create-stores',
            'edit-stores',
            'delete-stores',
            'view-stores',
            'create-users',
            'edit-users',
            'delete-users',
            'view-users',
            'create-vendors',
            'edit-vendors',
            'delete-vendors',
            'view-vendors',
            'create-scans',
            'edit-scans',
            'delete-scans',
            'view-scans',
            'create-manuals',
            'edit-manuals',
            'delete-manuals',
            'view-manuals',
        ]);

        $consultantRole->givePermissionTo([
            'create-dealerships',
            'edit-dealerships',
            'view-dealerships',
            'create-stores',
            'edit-stores',
            'view-stores',
            'create-users',
            'edit-users',
            'view-users',
            'create-vendors',
            'edit-vendors',
            'view-vendors',
            'create-scans',
            'edit-scans',
            'view-scans',
            'create-manuals',
            'edit-manuals',
            'view-manuals',
            'create-audits',
            'edit-audits',
            'delete-audits',
            'view-audits',
        ]);

        $ownerRole->givePermissionTo([
            'create-stores',
            'edit-stores',
            'create-users',
            'edit-users',
            'delete-users',
            'create-vendors',
            'edit-vendors',
            'view-scans',
            'view-manuals',
            'view-audits',
        ]);

        $gmRole->givePermissionTo([
            'create-stores',
            'edit-stores',
            'create-users',
            'edit-users',
            'delete-users',
            'create-vendors',
            'edit-vendors',
            'view-scans',
            'view-manuals',
            'view-audits',
        ]);

        $cfoRole->givePermissionTo([
            'create-stores',
            'edit-stores',
            'create-users',
            'edit-users',
            'delete-users',
            'create-vendors',
            'edit-vendors',
            'view-scans',
            'view-manuals',
            'view-audits',
        ]);

        $gsmRole->givePermissionTo([
            'create-stores',
            'edit-stores',
            'create-users',
            'edit-users',
            'delete-users',
            'create-vendors',
            'edit-vendors',
            'view-scans',
            'view-manuals',
            'view-audits',
        ]);

        $qiRole->givePermissionTo([
            'create-stores',
            'edit-stores',
            'view-stores',
            'create-users',
            'edit-users',
            'view-users',
            'create-vendors',
            'edit-vendors',
            'view-vendors',
            'create-scans',
            'edit-scans',
            'view-scans',
            'create-manuals',
            'edit-manuals',
            'view-manuals',
            'view-audits',
        ]);

        $managerRole->givePermissionTo([
            'create-users',
            'edit-users',
            'create-vendors',
            'edit-vendors',
            'view-vendors',
            'view-audits',
        ]);

        $employeeRole->givePermissionTo([

        ]);

        $porterDriverRole->givePermissionTo([

        ]);
    }
}
