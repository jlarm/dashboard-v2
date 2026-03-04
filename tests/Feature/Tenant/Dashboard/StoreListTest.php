<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Home\StoreList;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;

describe('dashboard store list', function (): void {
    it('selects a store and redirects to dashboard', function (): void {
        $store = Store::query()->firstOrFail();

        $this->consultant->update(['current_store_id' => null]);
        $this->actingAs($this->consultant);

        Livewire::test(StoreList::class)
            ->call('selectStore', $store->id)
            ->assertRedirect(route('dealer.dashboard'));

        expect($this->consultant->fresh()->current_store_id)->toBe($store->id);
    });

    it('forbids selecting a store outside the users scope', function (): void {
        $this->tenant->update(['locations' => true]);

        $assignedStore = Store::query()->firstOrFail();
        $unassignedStore = Store::query()->create([
            'name' => 'Unassigned Store '.uniqid(),
            'slug' => 'unassigned-store-'.uniqid(),
        ]);

        $manager = User::query()->create([
            'name' => 'Scoped Manager',
            'email' => 'scoped-manager@test.com',
            'password' => bcrypt('password'),
            'current_store_id' => null,
        ]);
        $manager->assignRole('Manager');
        $manager->stores()->attach($assignedStore->id);

        $this->actingAs($manager);

        Livewire::test(StoreList::class)
            ->call('selectStore', $unassignedStore->id)
            ->assertStatus(403);

        expect($manager->fresh()->current_store_id)->toBeNull();
    });

    it('does not repeat nullable grade queries for the same store while rendering the list', function (): void {
        $this->tenant->update(['locations' => true]);

        $storeA = Store::query()->firstOrFail();
        $storeB = Store::query()->create([
            'name' => 'Dashboard Query Store '.uniqid(),
            'slug' => 'dashboard-query-store-'.uniqid(),
        ]);

        $this->consultant->update(['current_store_id' => null]);
        $this->actingAs($this->consultant);

        DB::flushQueryLog();
        DB::enableQueryLog();

        Livewire::test(StoreList::class)->assertOk();

        $bodyShopQueriesByStore = collect(DB::getQueryLog())
            ->filter(fn (array $query): bool => str_contains((string) $query['query'], 'from `body_shop_violation_audits`'))
            ->filter(fn (array $query): bool => in_array($query['bindings'][0] ?? null, [$storeA->id, $storeB->id], true))
            ->groupBy(fn (array $query): int => (int) ($query['bindings'][0] ?? 0))
            ->map->count();

        expect($bodyShopQueriesByStore->get($storeA->id, 0))->toBeLessThanOrEqual(1)
            ->and($bodyShopQueriesByStore->get($storeB->id, 0))->toBeLessThanOrEqual(1);
    });
});
