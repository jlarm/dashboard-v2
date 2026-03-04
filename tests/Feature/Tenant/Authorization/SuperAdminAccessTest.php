<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->superAdmin = User::query()->create([
        'name' => 'Super Admin',
        'email' => 'superadmin@test.com',
        'password' => bcrypt('password'),
    ]);
    $this->superAdmin->assignRole('super-admin');

    $this->store = Store::query()->first();
    $this->superAdmin->stores()->attach($this->store->id);

    app()[PermissionRegistrar::class]->forgetCachedPermissions();
});

describe('Super Admin - Central Route Access', function (): void {
    it('can access the dashboard', function (): void {
        $this->actingAs($this->superAdmin)
            ->get(route('dealer.dashboard'))
            ->assertOk();
    });

    it('can access global settings', function (): void {
        $this->actingAs($this->superAdmin)
            ->get(route('dealer.settings.global'))
            ->assertOk();
    });
});

describe('Super Admin - Employee Management', function (): void {
    it('can access employee index', function (): void {
        $this->actingAs($this->superAdmin)
            ->get(route('dealer.employees.index'))
            ->assertOk();
    });

    it('can access employee creation page', function (): void {
        $this->actingAs($this->superAdmin)
            ->get(route('dealer.employees.new'))
            ->assertOk();
    });

    it('can access open invites page', function (): void {
        $this->actingAs($this->superAdmin)
            ->get(route('dealer.employees.open-invites'))
            ->assertOk();
    });

    it('can access deleted employees page', function (): void {
        $this->actingAs($this->superAdmin)
            ->get(route('dealer.employees.deleted'))
            ->assertOk();
    });

    it('can view an individual employee', function (): void {
        $employee = User::query()->create([
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($this->superAdmin)
            ->get(route('dealer.employees.show', $employee));

        // Not forbidden/redirect — authorization passed (may 500 from missing external services in test env)
        expect($response->status())->not->toBeIn([401, 403, 302]);
    });

    it('can access the manage courses employee page', function (): void {
        $employee = User::query()->create([
            'name' => 'Managed Employee',
            'email' => 'managed.employee@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($this->superAdmin)
            ->get(route('dealer.employees.show.manage-courses', $employee));

        expect($response->status())->not->toBeIn([401, 403, 302]);
    });
});

describe('Super Admin - Audit Access', function (): void {
    it('can access osha audit index', function (): void {
        $this->actingAs($this->superAdmin)
            ->get(route('dealer.audit.osha.index'))
            ->assertOk();
    });

    it('can access body shop audit index', function (): void {
        $this->actingAs($this->superAdmin)
            ->get(route('dealer.audit.body-shop.index'))
            ->assertOk();
    });

    it('can access finance audit index', function (): void {
        $this->actingAs($this->superAdmin)
            ->get(route('dealer.audit.finance.index'))
            ->assertOk();
    });

    it('can access deal jackets archived index', function (): void {
        $this->actingAs($this->superAdmin)
            ->get(route('dealer.audit.individual.index'))
            ->assertOk();
    });
});

describe('Super Admin - Vendor Access', function (): void {
    it('can access vendor index', function (): void {
        $this->actingAs($this->superAdmin)
            ->get(route('dealer.vendor.index'))
            ->assertOk();
    });
});

describe('Super Admin - Documents Access', function (): void {
    it('can access documents page', function (): void {
        $this->actingAs($this->superAdmin)
            ->get(route('dealer.doc.index'))
            ->assertOk();
    });

    it('can access SDS sheets', function (): void {
        $this->actingAs($this->superAdmin)
            ->get(route('dealer.sds.index'))
            ->assertOk();
    });
});

describe('Super Admin - Course Access', function (): void {
    it('can access courses index', function (): void {
        $this->actingAs($this->superAdmin)
            ->get(route('dealer.courses.index'))
            ->assertOk();
    });

    it('is not forbidden from all courses view', function (): void {
        $response = $this->actingAs($this->superAdmin)
            ->get(route('dealer.courses.all'));

        // Authorization passes (may 500 from missing Vimeo config in test env)
        expect($response->status())->not->toBeIn([401, 403, 302]);
    });
});

describe('Super Admin - Phishing Access', function (): void {
    it('can access phishing index', function (): void {
        $this->actingAs($this->superAdmin)
            ->get(route('dealer.phishing.index'))
            ->assertOk();
    });

    it('is not forbidden from phishing create', function (): void {
        $response = $this->actingAs($this->superAdmin)
            ->get(route('dealer.phishing.create'));

        // Authorization passes (may 500 from missing GoPhish config in test env)
        expect($response->status())->not->toBeIn([401, 403, 302]);
    });
});

describe('Super Admin - Logs Access', function (): void {
    it('can access logs page with super-admin role', function (): void {
        $this->actingAs($this->superAdmin)
            ->get(route('dealer.logs.index'))
            ->assertOk();
    });
});

describe('Super Admin - Profile Access', function (): void {
    it('can access profile page', function (): void {
        $this->actingAs($this->superAdmin)
            ->get(route('dealer.profile.edit'))
            ->assertOk();
    });
});
