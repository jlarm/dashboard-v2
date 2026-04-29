<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;

describe('switch store controller', function (): void {
    it('updates current_store_id for an accessible store', function (): void {
        $primary = Store::query()->firstOrFail();

        $second = Store::query()->create([
            'name' => 'Second Store',
            'slug' => 'second-store',
        ]);

        $this->manager->stores()->attach([$primary->id, $second->id]);

        $this->actingAs($this->manager)
            ->from(route('dealer.dashboard'))
            ->post(route('dealer.store.switch'), ['store_id' => $second->id])
            ->assertRedirect(route('dealer.dashboard'));

        expect($this->manager->fresh()->current_store_id)->toBe($second->id);
    });

    it('allows super-admin to switch to any store', function (): void {
        $second = Store::query()->create([
            'name' => 'Admin Target',
            'slug' => 'admin-target',
        ]);

        $admin = User::query()->create([
            'name' => 'Admin',
            'email' => 'admin@test-tenant.localhost',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('super-admin');

        $this->actingAs($admin)
            ->post(route('dealer.store.switch'), ['store_id' => $second->id])
            ->assertRedirect();

        expect($admin->fresh()->current_store_id)->toBe($second->id);
    });

    it('forbids switching to a store the user does not have access to', function (): void {
        $inaccessible = Store::query()->create([
            'name' => 'Off Limits',
            'slug' => 'off-limits',
        ]);

        $this->actingAs($this->manager)
            ->post(route('dealer.store.switch'), ['store_id' => $inaccessible->id])
            ->assertForbidden();

        expect($this->manager->fresh()->current_store_id)->toBeNull();
    });

    it('clears the current store when no store_id is sent', function (): void {
        $store = Store::query()->firstOrFail();

        $this->manager->stores()->attach($store->id);
        $this->manager->update(['current_store_id' => $store->id]);

        $this->actingAs($this->manager)
            ->post(route('dealer.store.switch'), ['store_id' => null])
            ->assertRedirect();

        expect($this->manager->fresh()->current_store_id)->toBeNull();
    });

    it('redirects to dashboard when switching to overview from a scans page', function (): void {
        $store = Store::query()->firstOrFail();

        $this->manager->stores()->attach($store->id);
        $this->manager->update(['current_store_id' => $store->id]);

        $this->actingAs($this->manager)
            ->withHeader('Referer', url('/scans'))
            ->post(route('dealer.store.switch'), ['store_id' => null])
            ->assertRedirect(route('dealer.dashboard'));
    });

    it('falls back to back() when switching to overview from any other page', function (): void {
        $store = Store::query()->firstOrFail();

        $this->manager->stores()->attach($store->id);
        $this->manager->update(['current_store_id' => $store->id]);

        $this->actingAs($this->manager)
            ->from(route('dealer.dashboard'))
            ->post(route('dealer.store.switch'), ['store_id' => null])
            ->assertRedirect(route('dealer.dashboard'));

        $this->actingAs($this->manager)
            ->withHeader('Referer', url('/employees'))
            ->post(route('dealer.store.switch'), ['store_id' => null])
            ->assertRedirect(url('/employees'));
    });

    it('validates that store_id exists', function (): void {
        $this->actingAs($this->manager)
            ->post(route('dealer.store.switch'), ['store_id' => 99999])
            ->assertSessionHasErrors('store_id');
    });

    it('requires authentication', function (): void {
        $store = Store::query()->firstOrFail();

        $this->post(route('dealer.store.switch'), ['store_id' => $store->id])
            ->assertRedirect(route('dealer.login'));
    });
});
