<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;

it('consultant access dashboard when logged in', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('tenant/Dashboard')
            ->where('is_overview', false)
            ->where('show_kpi_cards', true)
            ->where('can_download_audit_report', true)
            ->where('audit_quick_start_store_id', $store->id)
            ->has('consultant_note')
        );
});

it('manager access dashboard when logged in', function (): void {
    $this->actingAs($this->manager)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('tenant/Dashboard')
            ->where('show_kpi_cards', false)
            ->where('can_download_audit_report', false)
            ->where('audit_quick_start_store_id', null)
            ->where('consultant_note', null)
        );
});

it('consultant sees single-store widgets when current_store_id is null and only one store exists', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => null]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('tenant/Dashboard')
            ->where('is_overview', false)
            ->where('show_kpi_cards', true)
            ->where('audit_quick_start_store_id', $store->id)
        );
});

it('consultant sees group widgets with multiple accessible stores and null current_store_id', function (): void {
    Store::query()->create([
        'name' => 'Second Store',
        'slug' => 'second-store',
    ]);

    $this->consultant->update(['current_store_id' => null]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('tenant/Dashboard')
            ->where('is_overview', true)
            ->where('show_kpi_cards', true)
            ->where('audit_quick_start_store_id', null)
            ->has('stores', 2)
        );
});

it('super-admin sees overview mode with multiple scoped stores', function (): void {
    $superAdmin = User::query()->create([
        'name' => 'Dashboard Super Admin',
        'email' => 'dashboard-super-admin@test.com',
        'password' => 'password',
        'current_store_id' => null,
    ]);
    $superAdmin->assignRole('super-admin');

    Store::query()->create([
        'name' => 'Dashboard Super Admin Store B',
        'slug' => 'dashboard-super-admin-store-b',
    ]);

    $this->actingAs($superAdmin)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('tenant/Dashboard')
            ->where('is_overview', true)
            ->has('stores', 2)
        );
});
