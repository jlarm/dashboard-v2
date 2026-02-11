<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->store = Store::query()->first();
    $this->manager->stores()->attach($this->store->id);

    app()[PermissionRegistrar::class]->forgetCachedPermissions();
});

describe('Manager - General Access', function (): void {
    it('can access the dashboard', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.dashboard'))
            ->assertOk();
    });

    it('can access courses index', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.courses.index'))
            ->assertOk();
    });

    it('can access SDS sheets', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.sds.index'))
            ->assertOk();
    });

    it('can access videos index', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.videos.index'))
            ->assertOk();
    });

    it('can access profile page', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.profile.edit'))
            ->assertOk();
    });
});

describe('Manager - Employee Management', function (): void {
    it('can access employee index', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.employees.index'))
            ->assertOk();
    });

    it('can access employee creation page', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.employees.new'))
            ->assertOk();
    });

    it('can access open invites', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.employees.open-invites'))
            ->assertOk();
    });

    it('is not forbidden from viewing an individual employee', function (): void {
        $employee = User::query()->create([
            'name' => 'Emp For Manager',
            'email' => 'emp-mgr@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($this->manager)
            ->get(route('dealer.employees.show', $employee));

        expect($response->status())->not->toBeIn([401, 403, 302]);
    });
});

describe('Manager - Audit Access (View Only)', function (): void {
    it('can access osha audit index', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.audit.osha.index'))
            ->assertOk();
    });

    it('can access body shop audit index', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.audit.body-shop.index'))
            ->assertOk();
    });

    it('can access finance audit index', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.audit.finance.index'))
            ->assertOk();
    });

    it('can access deal jackets archived index', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.audit.individual.index'))
            ->assertOk();
    });
});

describe('Manager - Vendor Access', function (): void {
    it('can access vendor index', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.vendor.index'))
            ->assertOk();
    });
});

describe('Manager - Documents Access', function (): void {
    it('can access documents page', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.doc.index'))
            ->assertOk();
    });
});

describe('Manager - Routes It Should NOT Access', function (): void {
    it('cannot access global settings', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.settings.global'))
            ->assertForbidden();
    });

    it('cannot access all courses view', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.courses.all'))
            ->assertForbidden();
    });

    it('cannot create osha audits', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.audit.osha.create', $this->store->id))
            ->assertForbidden();
    });

    it('cannot create body shop audits', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.audit.body-shop.create', $this->store->id))
            ->assertForbidden();
    });

    it('cannot access phishing create', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.phishing.create'))
            ->assertForbidden();
    });

    it('cannot access deleted employees (QI+ only)', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.employee.deleted'))
            ->assertForbidden();
    });

    it('cannot access phishing index (QI+ only)', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.phishing.index'))
            ->assertForbidden();
    });

    it('cannot access logs', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.logs.index'))
            ->assertForbidden();
    });
});
