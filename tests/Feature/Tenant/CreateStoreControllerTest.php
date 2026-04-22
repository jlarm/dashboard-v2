<?php

declare(strict_types=1);

use App\Enums\State;
use App\Models\Dealer\Store;
use App\Models\User;

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

describe('create store controller', function (): void {
    it('creates a store when submitted by a consultant', function (): void {
        $this->actingAs($this->consultant)
            ->post(route('dealer.locations.store'), validLocationPayload())
            ->assertRedirect();

        expect(Store::query()->where('name', 'Brilliance Honda')->exists())->toBeTrue();
    });

    it('creates a store when submitted by a super-admin', function (): void {
        $admin = User::query()->create([
            'name' => 'Super Admin',
            'email' => 'sa@test-tenant.localhost',
            'password' => bcrypt('password'),
        ]);
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

    it('requires authentication', function (): void {
        $this->post(route('dealer.locations.store'), validLocationPayload())
            ->assertRedirect(route('dealer.login'));
    });
});
