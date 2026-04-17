<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

describe('legacy store slug routes', function (): void {
    beforeEach(function (): void {
        $this->tenant->locations = true;
        $this->tenant->save();
    });

    it('does not register legacy dealer.stores route names', function (): void {
        $store = Store::query()->firstOrFail();

        expect(fn (): string => route('dealer.stores.home', $store))
            ->toThrow(RouteNotFoundException::class);
    });

    it('redirects /stores to dashboard', function (): void {
        $this->actingAs($this->consultant)
            ->get('/stores')
            ->assertRedirect(route('dealer.dashboard'));
    });

    it('keeps /locations available for the new locations page', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.locations.index'))
            ->assertOk();
    });

    it('redirects legacy store home urls to dashboard', function (): void {
        $store = Store::query()->firstOrFail();

        $manager = User::query()->create([
            'name' => 'Legacy Route Manager',
            'email' => 'legacy-route-manager@test.com',
            'password' => bcrypt('password'),
            'current_store_id' => null,
        ]);
        $manager->assignRole('Manager');
        $manager->stores()->attach($store->id);

        $this->actingAs($manager)
            ->get('/stores/'.$store->slug)
            ->assertRedirect(route('dealer.dashboard'));
    });

    it('redirects legacy nested paths to dashboard and leaves current_store_id unchanged', function (): void {
        $store = Store::query()->firstOrFail();

        $manager = User::query()->create([
            'name' => 'Legacy Nested Route Manager',
            'email' => 'legacy-nested-route-manager@test.com',
            'password' => bcrypt('password'),
            'current_store_id' => null,
        ]);
        $manager->assignRole('Manager');
        $manager->stores()->attach($store->id);

        $this->actingAs($manager)
            ->get('/stores/'.$store->slug.'/employees')
            ->assertRedirect(route('dealer.dashboard'));

        expect($manager->fresh()->current_store_id)->toBeNull();
    });
});
