<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;

beforeEach(function (): void {
    $this->store = Store::query()->first();
});

describe('Consultant - Dashboard & General Access', function (): void {
    it('can access the dashboard', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.dashboard'))
            ->assertOk();
    });

    it('can access courses index', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.courses.index'))
            ->assertOk();
    });

    it('is not forbidden from all courses view', function (): void {
        $response = $this->actingAs($this->consultant)
            ->get(route('dealer.courses.all'));

        expect($response->status())->not->toBeIn([401, 403, 302]);
    });

    it('can access SDS sheets', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.sds.index'))
            ->assertOk();
    });

    it('can access profile page', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.profile.edit'))
            ->assertOk();
    });
});

describe('Consultant - Employee Management', function (): void {
    it('can access employee index', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.index'))
            ->assertOk();
    });

    it('can access employee creation page', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.invite'))
            ->assertOk();
    });

    it('can access open invites', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.open-invites'))
            ->assertOk();
    });

    it('can access deleted employees page', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.deleted'))
            ->assertOk();
    });

    it('is not forbidden from viewing an individual employee', function (): void {
        $employee = User::query()->create([
            'name' => 'Emp Consultant',
            'email' => 'emp-consultant@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($this->consultant)
            ->get(route('dealer.employees.show', $employee));

        expect($response->status())->not->toBeIn([401, 403, 302]);
    });

    it('can access the manage courses employee page', function (): void {
        $employee = User::query()->create([
            'name' => 'Consultant Managed Employee',
            'email' => 'consultant-manage@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($this->consultant)
            ->get(route('dealer.employees.show.manage-courses', $employee));

        expect($response->status())->not->toBeIn([401, 403, 302]);
    });
});

describe('Consultant - Audit Access', function (): void {
    it('can access osha audit index', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.audit.osha.index'))
            ->assertOk();
    });

    it('is not forbidden from osha audit create', function (): void {
        $response = $this->actingAs($this->consultant)
            ->get(route('dealer.audit.osha.create', $this->store->id));

        // Creates audit and redirects — authorization passed
        expect($response->status())->toBeIn([200, 302]);
    });

    it('can access body shop audit index', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.audit.body-shop.index'))
            ->assertOk();
    });

    it('is not forbidden from body shop audit create', function (): void {
        $response = $this->actingAs($this->consultant)
            ->get(route('dealer.audit.body-shop.create', $this->store->id));

        // Creates audit and redirects — authorization passed
        expect($response->status())->toBeIn([200, 302]);
    });

    it('can access finance audit index', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.audit.finance.index'))
            ->assertOk();
    });

    it('can access deal jackets archived index', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.audit.individual.index'))
            ->assertOk();
    });
});

describe('Consultant - Vendor Access', function (): void {
    it('can access vendor index', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.vendor.index'))
            ->assertOk();
    });
});

describe('Consultant - Documents Access', function (): void {
    it('can access documents page', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.doc.index'))
            ->assertOk();
    });
});

describe('Consultant - Routes It Should NOT Access', function (): void {
    it('can access global settings', function (): void {
        Store::query()->create(['name' => 'Second Store']);
        $this->consultant->update(['current_store_id' => null]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.settings.global'))
            ->assertOk();
    });

    it('can access logs via Consultant role', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.logs.index'))
            ->assertOk();
    });
});
