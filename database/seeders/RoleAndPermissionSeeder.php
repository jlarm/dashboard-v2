<?php

namespace Database\Seeders;

use DB;
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('roles')->truncate();

        Permission::create(['name' => 'create-dealerships']);
        Permission::create(['name' => 'edit-dealerships']);
        Permission::create(['name' => 'delete-dealerships']);
        Permission::create(['name' => 'view-dealerships']);

        Permission::create(['name' => 'create-stores']);
        Permission::create(['name' => 'edit-stores']);
        Permission::create(['name' => 'delete-stores']);
        Permission::create(['name' => 'view-stores']);

        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);
        Permission::create(['name' => 'view-users']);

        Permission::create(['name' => 'create-vendors']);
        Permission::create(['name' => 'edit-vendors']);
        Permission::create(['name' => 'delete-vendors']);
        Permission::create(['name' => 'view-vendors']);

        Permission::create(['name' => 'create-scans']);
        Permission::create(['name' => 'edit-scans']);
        Permission::create(['name' => 'delete-scans']);
        Permission::create(['name' => 'view-scans']);

        Permission::create(['name' => 'create-manuals']);
        Permission::create(['name' => 'edit-manuals']);
        Permission::create(['name' => 'delete-manuals']);
        Permission::create(['name' => 'view-manuals']);

        Permission::create(['name' => 'create-audits']);
        Permission::create(['name' => 'edit-audits']);
        Permission::create(['name' => 'delete-audits']);
        Permission::create(['name' => 'view-audits']);

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
