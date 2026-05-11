<?php

declare(strict_types=1);

use App\Models\Dealer\PhishingCampaign;
use App\Models\Dealer\Store;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->employee = User::query()->create([
        'name' => 'Employee User',
        'email' => 'employee@test.com',
        'password' => bcrypt('password'),
    ]);
    $this->employee->assignRole('Employee');

    $this->store = Store::query()->first();
    $this->employee->stores()->attach($this->store->id);
    $this->employee->update(['current_store_id' => $this->store->id]);

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

describe('Employee - Allowed Access', function (): void {
    it('can access the dashboard', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.dashboard'))
            ->assertOk();
    });

    it('can access courses index', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.courses.index'))
            ->assertOk();
    });

    it('can access SDS sheets', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.sds.index'))
            ->assertOk();
    });

    it('can access profile page', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.profile.edit'))
            ->assertOk();
    });
});

describe('Employee - Forbidden Routes (Super-Admin Only)', function (): void {
    it('cannot access global settings', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.settings.global'))
            ->assertForbidden();
    });
});

describe('Employee - Forbidden Routes (Super-Admin|Consultant Only)', function (): void {
    it('cannot access all courses view', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.courses.all'))
            ->assertForbidden();
    });

    it('cannot create osha audits', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.audit.osha.create', $this->store->id))
            ->assertForbidden();
    });

    it('cannot create body shop audits', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.audit.body-shop.create', $this->store->id))
            ->assertForbidden();
    });

    it('cannot create phishing campaigns', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.phishing.create'))
            ->assertForbidden();
    });
});

describe('Employee - Forbidden Routes (QI+ Only)', function (): void {
    it('cannot access deleted employees page', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.employees.deleted'))
            ->assertForbidden();
    });

    it('cannot access phishing index', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.phishing.index'))
            ->assertForbidden();
    });

    it('cannot access dealer settings', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.dealer.settings'))
            ->assertForbidden();
    });

    it('cannot access store edit', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.store.edit'))
            ->assertForbidden();
    });

    it('cannot access phishing campaign details', function (): void {
        $campaign = PhishingCampaign::query()->create([
            'campaign_id' => 'employee-campaign-1',
            'user_id' => $this->employee->id,
            'store_id' => $this->store->id,
            'name' => 'Employee Forbidden Campaign',
            'status' => 'In progress',
            'campaign_created_at' => now(),
        ]);

        $this->actingAs($this->employee)
            ->get(route('dealer.phishing.show', $campaign))
            ->assertForbidden();
    });
});

describe('Employee - Forbidden Routes (Manager+ Only)', function (): void {
    it('cannot access employee index', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.employees.index'))
            ->assertForbidden();
    });

    it('cannot access employee creation page', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.employees.invite'))
            ->assertForbidden();
    });

    it('cannot access open invites page', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.employees.open-invites'))
            ->assertForbidden();
    });

    it('cannot access osha audit index', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.audit.osha.index'))
            ->assertForbidden();
    });

    it('cannot access body shop audit index', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.audit.body-shop.index'))
            ->assertForbidden();
    });

    it('cannot access finance audit index', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.audit.finance.index'))
            ->assertForbidden();
    });

    it('cannot access deal jackets archived index', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.audit.individual.index'))
            ->assertForbidden();
    });

    it('cannot access vendor index', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.vendor.index'))
            ->assertForbidden();
    });

    it('cannot access documents page', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.doc.index'))
            ->assertForbidden();
    });

    it('cannot access fit tests page', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.fit-tests.index'))
            ->assertForbidden();
    });

    it('cannot access scan routes', function (string $routeName): void {
        $this->actingAs($this->employee)
            ->get(route($routeName))
            ->assertForbidden();
    })->with([
        'scan index' => 'dealer.scan.index',
        'scan settings' => 'dealer.scan.settings',
        'scan archive' => 'dealer.scan.archive',
    ]);
});

describe('Employee - Forbidden Routes (Consultant Only)', function (): void {
    it('cannot access locations index', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.locations.index'))
            ->assertForbidden();
    });

    it('cannot access ridgeback index', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.ridgeback.index'))
            ->assertForbidden();
    });
});

describe('Employee - Forbidden Routes (Logs)', function (): void {
    it('cannot access logs', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.logs.index'))
            ->assertForbidden();
    });
});
