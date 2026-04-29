<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();

    $this->qi = User::query()->create([
        'name' => 'Manual QI User',
        'email' => 'manual-qi@test.com',
        'password' => bcrypt('password'),
        'current_store_id' => $this->store->id,
    ]);
    $this->qi->assignRole('Qualified Individual');
    $this->qi->stores()->sync([$this->store->id]);

    $this->manager = User::query()->create([
        'name' => 'Manual Manager User',
        'email' => 'manual-manager@test.com',
        'password' => bcrypt('password'),
        'current_store_id' => $this->store->id,
    ]);
    $this->manager->assignRole('Manager');
    $this->manager->stores()->sync([$this->store->id]);

    $this->employee = User::query()->create([
        'name' => 'Manual Employee User',
        'email' => 'manual-employee@test.com',
        'password' => bcrypt('password'),
        'current_store_id' => $this->store->id,
    ]);
    $this->employee->assignRole('Employee');
    $this->employee->stores()->sync([$this->store->id]);

    $this->admin = User::query()->create([
        'name' => 'Manual Admin User',
        'email' => 'manual-admin@test.com',
        'password' => bcrypt('password'),
        'current_store_id' => $this->store->id,
    ]);
    $this->admin->assignRole('Admin');
    $this->admin->stores()->sync([$this->store->id]);

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

describe('manual route access', function (): void {
    it('allows QI users to access manual routes', function (string $routeName): void {
        $this->actingAs($this->qi)
            ->get(route($routeName))
            ->assertOk();
    })->with([
        'CMS index' => 'dealer.manual.cms.index',
        'CMS create' => 'dealer.manual.cms.create',
        'ISP index' => 'dealer.manual.isp.index',
        'ISP create' => 'dealer.manual.isp.create',
        'OSHA index' => 'dealer.manual.osha.index',
        'OSHA create' => 'dealer.manual.osha.create',
        'Red Flag index' => 'dealer.manual.red-flag.index',
        'Red Flag create' => 'dealer.manual.red-flag.create',
    ]);

    it('forbids lower access roles from manual routes', function (string $userProperty, string $routeName): void {
        $this->actingAs($this->{$userProperty})
            ->get(route($routeName))
            ->assertForbidden();
    })->with([
        'manager CMS index' => ['manager', 'dealer.manual.cms.index'],
        'manager CMS create' => ['manager', 'dealer.manual.cms.create'],
        'manager ISP index' => ['manager', 'dealer.manual.isp.index'],
        'manager ISP create' => ['manager', 'dealer.manual.isp.create'],
        'manager OSHA index' => ['manager', 'dealer.manual.osha.index'],
        'manager OSHA create' => ['manager', 'dealer.manual.osha.create'],
        'manager Red Flag index' => ['manager', 'dealer.manual.red-flag.index'],
        'manager Red Flag create' => ['manager', 'dealer.manual.red-flag.create'],
        'employee CMS index' => ['employee', 'dealer.manual.cms.index'],
        'employee CMS create' => ['employee', 'dealer.manual.cms.create'],
        'employee ISP index' => ['employee', 'dealer.manual.isp.index'],
        'employee ISP create' => ['employee', 'dealer.manual.isp.create'],
        'employee OSHA index' => ['employee', 'dealer.manual.osha.index'],
        'employee OSHA create' => ['employee', 'dealer.manual.osha.create'],
        'employee Red Flag index' => ['employee', 'dealer.manual.red-flag.index'],
        'employee Red Flag create' => ['employee', 'dealer.manual.red-flag.create'],
    ]);

    it('allows Admin users to access migrated manual routes', function (string $routeName): void {
        $this->actingAs($this->admin)
            ->get(route($routeName))
            ->assertOk();
    })->with([
        'ISP index' => 'dealer.manual.isp.index',
        'ISP create' => 'dealer.manual.isp.create',
        'OSHA index' => 'dealer.manual.osha.index',
        'OSHA create' => 'dealer.manual.osha.create',
        'Red Flag index' => 'dealer.manual.red-flag.index',
        'Red Flag create' => 'dealer.manual.red-flag.create',
        'CMS index' => 'dealer.manual.cms.index',
        'CMS create' => 'dealer.manual.cms.create',
    ]);
});
