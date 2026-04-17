<?php

declare(strict_types=1);

use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

describe('Logs Index Page - Authorization', function (): void {
    it('allows users with delete-stores permission to access logs page', function (): void {
        $user = User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Admin');

        // Refresh permissions cache
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->actingAs($user)
            ->get(route('dealer.logs.index'))
            ->assertOk();
    });

    it('denies consultant role without delete-stores permission from accessing logs page', function (): void {
        $user = User::query()->create([
            'name' => 'Consultant User',
            'email' => 'consultant@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Consultant');

        $this->actingAs($user)
            ->get(route('dealer.logs.index'))
            ->assertForbidden();
    });

    it('allows consultant with delete-stores permission to access logs page', function (): void {
        $user = User::query()->create([
            'name' => 'Consultant User',
            'email' => 'consultant-with-perm@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Consultant');
        $user->givePermissionTo('delete-stores');

        $this->actingAs($user)
            ->get(route('dealer.logs.index'))
            ->assertOk();
    });

    it('denies users without delete-stores permission from accessing logs page', function (): void {
        $user = User::query()->create([
            'name' => 'Employee User',
            'email' => 'employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $this->actingAs($user)
            ->get(route('dealer.logs.index'))
            ->assertForbidden();
    });

    it('denies manager role without delete-stores permission from accessing logs page', function (): void {
        $user = User::query()->create([
            'name' => 'Manager User',
            'email' => 'manager@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Manager');

        $this->actingAs($user)
            ->get(route('dealer.logs.index'))
            ->assertForbidden();
    });

    it('denies qualified individual role without delete-stores permission from accessing logs page', function (): void {
        $user = User::query()->create([
            'name' => 'QI User',
            'email' => 'qi@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Qualified Individual');

        $this->actingAs($user)
            ->get(route('dealer.logs.index'))
            ->assertForbidden();
    });

    it('denies guest users from accessing logs page', function (): void {
        $this->get(route('dealer.logs.index'))
            ->assertRedirect(route('dealer.login'));
    });
});
