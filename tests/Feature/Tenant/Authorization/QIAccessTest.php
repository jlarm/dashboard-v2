<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->qi = User::query()->create([
        'name' => 'QI User',
        'email' => 'qi@test.com',
        'password' => bcrypt('password'),
    ]);
    $this->qi->assignRole('Qualified Individual');

    $this->store = Store::query()->first();
    $this->qi->stores()->attach($this->store->id);

    app()[PermissionRegistrar::class]->forgetCachedPermissions();
});

describe('QI - General Access', function (): void {
    it('can access the dashboard', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.dashboard'))
            ->assertOk();
    });

    it('can access courses index', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.courses.index'))
            ->assertOk();
    });

    it('can access SDS sheets', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.sds.index'))
            ->assertOk();
    });

    it('can access videos index', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.videos.index'))
            ->assertOk();
    });

    it('can access profile page', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.profile.edit'))
            ->assertOk();
    });
});

describe('QI - Employee Management', function (): void {
    it('can access employee index', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.employees.index'))
            ->assertOk();
    });

    it('can access deleted employees page', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.employee.deleted'))
            ->assertOk();
    });

    it('is not forbidden from viewing an individual employee', function (): void {
        $employee = User::query()->create([
            'name' => 'Emp For QI',
            'email' => 'emp-qi@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($this->qi)
            ->get(route('dealer.employees.show', $employee));

        expect($response->status())->not->toBeIn([401, 403, 302]);
    });
});

describe('QI - Audit Access', function (): void {
    it('can access osha audit index', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.audit.osha.index'))
            ->assertOk();
    });

    it('can access body shop audit index', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.audit.body-shop.index'))
            ->assertOk();
    });

    it('can access finance audit index', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.audit.finance.index'))
            ->assertOk();
    });

    it('can access deal jackets archived index', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.audit.individual.index'))
            ->assertOk();
    });
});

describe('QI - Vendor Access', function (): void {
    it('can access vendor index', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.vendor.index'))
            ->assertOk();
    });
});

describe('QI - Documents Access', function (): void {
    it('can access documents page', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.doc.index'))
            ->assertOk();
    });
});

describe('QI - Phishing Access', function (): void {
    it('can access phishing index', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.phishing.index'))
            ->assertOk();
    });
});

describe('QI - Routes It Should NOT Access', function (): void {
    it('cannot access global settings', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.settings.global'))
            ->assertForbidden();
    });

    it('cannot access all courses view', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.courses.all'))
            ->assertForbidden();
    });

    it('cannot create osha audits (super-admin|Consultant only)', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.audit.osha.create', $this->store->id))
            ->assertForbidden();
    });

    it('cannot create body shop audits (super-admin|Consultant only)', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.audit.body-shop.create', $this->store->id))
            ->assertForbidden();
    });

    it('cannot access phishing create (super-admin|Consultant only)', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.phishing.create'))
            ->assertForbidden();
    });

    it('cannot access logs', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.logs.index'))
            ->assertForbidden();
    });
});
