<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->admin = User::query()->create([
        'name' => 'Admin User',
        'email' => 'admin@test.com',
        'password' => bcrypt('password'),
    ]);
    $this->admin->assignRole('Admin');

    $this->store = Store::query()->first();
    $this->admin->stores()->attach($this->store->id);

    app()[PermissionRegistrar::class]->forgetCachedPermissions();
});

describe('Admin - General Access', function (): void {
    it('can access the dashboard', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.dashboard'))
            ->assertOk();
    });

    it('can access courses index', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.courses.index'))
            ->assertOk();
    });

    it('can access SDS sheets', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.sds.index'))
            ->assertOk();
    });

    it('can access videos index', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.videos.index'))
            ->assertOk();
    });

    it('can access profile page', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.profile.edit'))
            ->assertOk();
    });
});

describe('Admin - Logs Access (via delete-stores permission)', function (): void {
    it('can access logs because Admin role has delete-stores permission', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.logs.index'))
            ->assertOk();
    });
});

describe('Admin - Routes It Should NOT Access', function (): void {
    it('cannot access global settings', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.settings.global'))
            ->assertForbidden();
    });

    it('cannot access all courses view (super-admin|Consultant only)', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.courses.all'))
            ->assertForbidden();
    });

    it('cannot access osha audit create (super-admin|Consultant only)', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.audit.osha.create', $this->store->id))
            ->assertForbidden();
    });

    it('cannot access body shop audit create (super-admin|Consultant only)', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.audit.body-shop.create', $this->store->id))
            ->assertForbidden();
    });

    it('cannot access phishing create (super-admin|Consultant only)', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.phishing.create'))
            ->assertForbidden();
    });

    it('cannot access employee index (not in manager+ role group)', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.employees.index'))
            ->assertForbidden();
    });

    it('cannot access audit osha index (not in manager+ role group)', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.audit.osha.index'))
            ->assertForbidden();
    });

    it('cannot access vendor index (not in manager+ role group)', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.vendor.index'))
            ->assertForbidden();
    });
});
