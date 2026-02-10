<?php

declare(strict_types=1);

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
        Permission::query()->firstOrCreate(['name' => 'create-dealerships']);
        Permission::query()->firstOrCreate(['name' => 'edit-dealerships']);
        Permission::query()->firstOrCreate(['name' => 'delete-dealerships']);
        Permission::query()->firstOrCreate(['name' => 'view-dealerships']);

        Permission::query()->firstOrCreate(['name' => 'create-stores']);
        Permission::query()->firstOrCreate(['name' => 'edit-stores']);
        Permission::query()->firstOrCreate(['name' => 'delete-stores']);
        Permission::query()->firstOrCreate(['name' => 'view-stores']);

        Permission::query()->firstOrCreate(['name' => 'create-users']);
        Permission::query()->firstOrCreate(['name' => 'edit-users']);
        Permission::query()->firstOrCreate(['name' => 'delete-users']);
        Permission::query()->firstOrCreate(['name' => 'view-users']);

        Permission::query()->firstOrCreate(['name' => 'create-vendors']);
        Permission::query()->firstOrCreate(['name' => 'edit-vendors']);
        Permission::query()->firstOrCreate(['name' => 'delete-vendors']);
        Permission::query()->firstOrCreate(['name' => 'view-vendors']);

        Permission::query()->firstOrCreate(['name' => 'create-scans']);
        Permission::query()->firstOrCreate(['name' => 'edit-scans']);
        Permission::query()->firstOrCreate(['name' => 'delete-scans']);
        Permission::query()->firstOrCreate(['name' => 'view-scans']);

        Permission::query()->firstOrCreate(['name' => 'create-manuals']);
        Permission::query()->firstOrCreate(['name' => 'edit-manuals']);
        Permission::query()->firstOrCreate(['name' => 'delete-manuals']);
        Permission::query()->firstOrCreate(['name' => 'view-manuals']);

        Permission::query()->firstOrCreate(['name' => 'create-audits']);
        Permission::query()->firstOrCreate(['name' => 'edit-audits']);
        Permission::query()->firstOrCreate(['name' => 'delete-audits']);
        Permission::query()->firstOrCreate(['name' => 'view-audits']);

        Role::query()->firstOrCreate(['name' => 'super-admin']);

        $adminRole = Role::query()->firstOrCreate(['name' => 'Admin']);
        $consultantRole = Role::query()->firstOrCreate(['name' => 'Consultant']);
        $ownerRole = Role::query()->firstOrCreate(['name' => 'Owner']);
        $qiRole = Role::query()->firstOrCreate(['name' => 'Qualified Individual']);
        $gmRole = Role::query()->firstOrCreate(['name' => 'GM']);
        $cfoRole = Role::query()->firstOrCreate(['name' => 'CFO']);
        $gsmRole = Role::query()->firstOrCreate(['name' => 'GSM']);
        $managerRole = Role::query()->firstOrCreate(['name' => 'Manager']);
        $employeeRole = Role::query()->firstOrCreate(['name' => 'Employee']);
        $porterDriverRole = Role::query()->firstOrCreate(['name' => 'Porter/Driver']);

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

        // Sync permissions instead of adding to ensure clean state
        $consultantRole->syncPermissions([
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
