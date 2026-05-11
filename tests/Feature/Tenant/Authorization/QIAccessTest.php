<?php

declare(strict_types=1);

use App\Models\Dealer\PhishingCampaign;
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
    $this->qi->update(['current_store_id' => $this->store->id]);

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
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
            ->get(route('dealer.employees.deleted'))
            ->assertOk();
    });

    it('is not forbidden from viewing an individual employee', function (): void {
        $employee = User::query()->create([
            'name' => 'Emp For QI',
            'email' => 'emp-qi@test.com',
            'password' => bcrypt('password'),
        ]);
        $employee->stores()->attach($this->store->id);

        $response = $this->actingAs($this->qi)
            ->get(route('dealer.employees.show', $employee));

        expect($response->status())->not->toBeIn([401, 403, 302]);
    });

    it('cannot view an employee from a different store', function (): void {
        $otherStore = Store::query()->create([
            'name' => 'Other QI Store',
            'address' => '988 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $employee = User::query()->create([
            'name' => 'Hidden QI Employee',
            'email' => 'hidden-qi@test.com',
            'password' => bcrypt('password'),
        ]);
        $employee->stores()->attach($otherStore->id);

        $this->actingAs($this->qi)
            ->get(route('dealer.employees.show', $employee))
            ->assertForbidden();
    });

    it('can access the manage courses employee page', function (): void {
        $employee = User::query()->create([
            'name' => 'QI Manage Employee',
            'email' => 'qi-manage@test.com',
            'password' => bcrypt('password'),
        ]);
        $employee->stores()->attach($this->store->id);

        $this->actingAs($this->qi)
            ->get(route('dealer.employees.show.manage-courses', $employee))
            ->assertOk();
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

    it('can access phishing campaign details', function (): void {
        $campaign = PhishingCampaign::query()->create([
            'campaign_id' => 'qi-campaign-1',
            'user_id' => $this->qi->id,
            'store_id' => $this->store->id,
            'name' => 'QI Campaign',
            'status' => 'In progress',
            'campaign_created_at' => now(),
        ]);

        $this->actingAs($this->qi)
            ->get(route('dealer.phishing.show', $campaign))
            ->assertOk();
    });
});

describe('QI - Store And Manual Access', function (): void {
    it('can access store settings', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.dealer.settings'))
            ->assertOk();
    });

    it('can access store edit', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.store.edit'))
            ->assertOk();
    });
});

describe('QI - Manager Group Access', function (): void {
    it('can access scan routes', function (string $routeName): void {
        $this->actingAs($this->qi)
            ->get(route($routeName))
            ->assertOk();
    })->with([
        'scan index' => 'dealer.scan.index',
        'scan archive' => 'dealer.scan.archive',
    ]);

    it('cannot access scan settings (super-admin|Consultant only)', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.scan.settings'))
            ->assertForbidden();
    });

    it('can access fit tests', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.fit-tests.index'))
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

    it('cannot access locations index', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.locations.index'))
            ->assertForbidden();
    });

    it('cannot access ridgeback index', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.ridgeback.index'))
            ->assertForbidden();
    });

    it('cannot access logs', function (): void {
        $this->actingAs($this->qi)
            ->get(route('dealer.logs.index'))
            ->assertForbidden();
    });
});
