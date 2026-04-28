<?php

declare(strict_types=1);

use App\Enums\State;
use App\Models\Dealer\Store;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

function validLocationPayload(array $overrides = []): array
{
    return array_replace([
        'name' => 'Brilliance Honda',
        'address' => '123 Auto Row',
        'city' => 'Springfield',
        'state' => State::ILLINOIS->value,
        'postal_code' => '62701',
        'phone' => '555-111-2222',
        'website' => 'https://brilliance-honda.test',
    ], $overrides);
}

describe('locations index', function (): void {
    it('renders the inertia page for consultants', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.locations.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/location/Index')
                ->has('locations.data')
                ->where('can.create', true)
                ->where('can.update', true));
    });

    it('renders the inertia page for super-admins', function (): void {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super-admin');

        $this->actingAs($superAdmin)
            ->get(route('dealer.locations.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/location/Index')
                ->where('can.create', true)
                ->where('can.update', true));
    });

    it('forbids managers', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.locations.index'))
            ->assertForbidden();
    });

    it('redirects guests to login', function (): void {
        $this->get(route('dealer.locations.index'))
            ->assertRedirect(route('dealer.login'));
    });

    it('lists stores ordered by name', function (): void {
        Store::query()->create([
            'name' => 'Zebra Motors',
            'address' => '99 End St',
            'city' => 'Seattle',
            'state' => 'WA',
            'postal_code' => '98101',
            'phone' => '206-555-9999',
            'website' => 'https://zebra.test',
        ]);
        Store::query()->create([
            'name' => 'Alpha Motors',
            'address' => '1 Start St',
            'city' => 'Detroit',
            'state' => 'MI',
            'postal_code' => '48201',
            'phone' => '313-555-0000',
            'website' => 'https://alpha.test',
        ]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.locations.index'))
            ->assertInertia(fn ($page) => $page
                ->component('tenant/location/Index')
                ->where('locations.data.0.name', 'Alpha Motors')
                ->where('locations.data.1.name', 'Test Store')
                ->where('locations.data.2.name', 'Zebra Motors'));
    });
});

describe('locations store', function (): void {
    it('creates a store when submitted by a consultant', function (): void {
        $this->actingAs($this->consultant)
            ->post(route('dealer.locations.store'), validLocationPayload())
            ->assertRedirect();

        expect(Store::query()->where('name', 'Brilliance Honda')->exists())->toBeTrue();
    });

    it('creates a store when submitted by a super-admin', function (): void {
        $admin = User::factory()->create();
        $admin->assignRole('super-admin');

        $this->actingAs($admin)
            ->post(route('dealer.locations.store'), validLocationPayload(['name' => 'Admin Store']))
            ->assertRedirect();

        expect(Store::query()->where('name', 'Admin Store')->exists())->toBeTrue();
    });

    it('forbids managers from creating a store', function (): void {
        $this->actingAs($this->manager)
            ->post(route('dealer.locations.store'), validLocationPayload(['name' => 'Manager Store']))
            ->assertForbidden();

        expect(Store::query()->where('name', 'Manager Store')->exists())->toBeFalse();
    });

    it('rejects an invalid state value', function (): void {
        $this->actingAs($this->consultant)
            ->post(route('dealer.locations.store'), validLocationPayload(['state' => 'ZZ']))
            ->assertSessionHasErrors('state');
    });
});

describe('locations update', function (): void {
    it('updates a store when submitted by a consultant', function (): void {
        $store = Store::query()->firstOrFail();

        $this->actingAs($this->consultant)
            ->patch(route('dealer.locations.update', $store), validLocationPayload([
                'name' => 'Renamed Location',
                'city' => 'Columbus',
                'state' => State::OHIO->value,
            ]))
            ->assertRedirect();

        expect($store->fresh())
            ->name->toBe('Renamed Location')
            ->city->toBe('Columbus')
            ->state->toBe('OH');
    });

    it('forbids managers from updating a store', function (): void {
        $store = Store::query()->firstOrFail();

        $this->actingAs($this->manager)
            ->patch(route('dealer.locations.update', $store), validLocationPayload(['name' => 'Manager Edit']))
            ->assertForbidden();

        expect($store->fresh()->name)->not->toBe('Manager Edit');
    });

    it('allows keeping the same name when updating', function (): void {
        $store = Store::query()->firstOrFail();

        $this->actingAs($this->consultant)
            ->patch(route('dealer.locations.update', $store), validLocationPayload([
                'name' => $store->name,
                'address' => '999 Updated Way',
            ]))
            ->assertRedirect();

        expect($store->fresh()->address)->toBe('999 Updated Way');
    });

    it('rejects a duplicate name from another store', function (): void {
        $other = Store::query()->create([
            'name' => 'Other Location',
            'address' => '1 Other St',
            'city' => 'Phoenix',
            'state' => 'AZ',
            'postal_code' => '85001',
            'phone' => '602-555-0001',
            'website' => 'https://other.test',
        ]);

        $store = Store::query()->where('id', '!=', $other->id)->firstOrFail();

        $this->actingAs($this->consultant)
            ->patch(route('dealer.locations.update', $store), validLocationPayload(['name' => 'Other Location']))
            ->assertSessionHasErrors('name');
    });
});
