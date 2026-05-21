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
    $this->admin->update(['current_store_id' => $this->store->id]);

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
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

    it('can access profile page', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.profile.edit'))
            ->assertOk();
    });
});

describe('Admin - Logs Access', function (): void {
    it('cannot access logs (super-admin|Consultant only)', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.logs.index'))
            ->assertForbidden();
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

    it('can access vendor index (auth-only route)', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.vendor.index'))
            ->assertOk();
    });

    it('cannot access scan routes (not in manager+ role group)', function (string $routeName): void {
        $this->actingAs($this->admin)
            ->get(route($routeName))
            ->assertForbidden();
    })->with([
        'scan index' => 'dealer.scan.index',
        'scan settings' => 'dealer.scan.settings',
        'scan archive' => 'dealer.scan.archive',
    ]);

    it('cannot access fit tests (not in manager+ role group)', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.fit-tests.index'))
            ->assertForbidden();
    });

    it('cannot access deleted employees (QI+ only)', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.employees.deleted'))
            ->assertForbidden();
    });

    it('cannot access store settings (QI+ only)', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.dealer.settings'))
            ->assertForbidden();
    });

    it('cannot access consultant-only location management', function (): void {
        $this->actingAs($this->admin)
            ->get(route('dealer.locations.index'))
            ->assertForbidden();
    });

});
