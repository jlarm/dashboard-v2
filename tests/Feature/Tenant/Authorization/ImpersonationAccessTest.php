<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;
use Spatie\Permission\Models\Permission;

beforeEach(function (): void {
    $store = Store::query()->firstOrFail();

    $this->targetUser = User::query()->create([
        'name' => 'Impersonation Target',
        'email' => 'impersonation-target@test.com',
        'password' => bcrypt('password'),
    ]);

    $this->targetUser->assignRole('Employee');
    $this->targetUser->stores()->attach($store->id);
});

it('allows consultants to impersonate', function (): void {
    $response = $this->actingAs($this->consultant)
        ->get(route('dealer.employee.impersonate', $this->targetUser));

    $response->assertRedirect();
    expect($response->headers->get('Location'))->toContain('/impersonate/');
});

it('allows super-admin users to impersonate', function (): void {
    $superAdmin = User::query()->create([
        'name' => 'Impersonation Super Admin',
        'email' => 'impersonation-super-admin@test.com',
        'password' => bcrypt('password'),
    ]);
    $superAdmin->assignRole('super-admin');

    $response = $this->actingAs($superAdmin)
        ->get(route('dealer.employee.impersonate', $this->targetUser));

    $response->assertRedirect();
    expect($response->headers->get('Location'))->toContain('/impersonate/');
});

it('forbids managers even when given impersonate-users permission', function (): void {
    $permission = Permission::query()->firstOrCreate(['name' => 'impersonate-users']);
    $this->manager->givePermissionTo($permission);

    $this->actingAs($this->manager)
        ->get(route('dealer.employee.impersonate', $this->targetUser))
        ->assertForbidden();
});

it('forbids qualified individuals even when given impersonate-users permission', function (): void {
    $qi = User::query()->create([
        'name' => 'Impersonation QI',
        'email' => 'impersonation-qi@test.com',
        'password' => bcrypt('password'),
    ]);
    $qi->assignRole('Qualified Individual');

    $permission = Permission::query()->firstOrCreate(['name' => 'impersonate-users']);
    $qi->givePermissionTo($permission);

    $this->actingAs($qi)
        ->get(route('dealer.employee.impersonate', $this->targetUser))
        ->assertForbidden();
});
