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
            ->assertOk()
            ->assertSee('Settings Overview')
            ->assertSee($storeA->name)
            ->assertSee($storeB->name);
    });
});
