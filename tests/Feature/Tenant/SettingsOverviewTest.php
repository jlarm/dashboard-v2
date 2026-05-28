<?php

declare(strict_types=1);

use App\Models\Dealer\Store;

describe('settings overview', function (): void {
    it('shows all scoped stores when current_store_id is null', function (): void {
        $this->tenant->locations = true;
        $this->tenant->save();

        $storeA = Store::query()->firstOrFail();
        $storeB = Store::query()->create([
            'name' => 'Settings Overview Store B',
            'slug' => 'settings-overview-store-b',
        ]);

        $this->consultant->update(['current_store_id' => null]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.dealer.settings'))
            ->assertRedirect(route('dealer.settings.global'));

        $this->actingAs($this->consultant)
            ->get(route('dealer.settings.global'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/settings/GlobalSettings')
                ->where('stores', fn (Illuminate\Support\Collection $stores): bool => $stores->pluck('name')->sort()->values()->all() === collect([$storeA->name, $storeB->name])->sort()->values()->all())
            );
    });
});
