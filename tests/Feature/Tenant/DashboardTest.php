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
        ->assertSee('<title>'.$store->name.'</title>', false)
        ->assertSee('OSHA Rating')
        ->assertSee('IT Scans')
        ->assertSee('Manuals')
        ->assertSee('Audits')
        ->assertSee('Settings')
        ->assertSeeLivewire('dealer.home.osha-stats')
        ->assertSeeLivewire('dealer.home.body-shop-stats')
        ->assertSeeLivewire('dealer.home.glba-stats')
        ->assertSeeLivewire('dealer.home.deal-jacket-stats')
        ->assertSeeLivewire('dealer.employee.department-completion-stats')
        ->assertSeeLivewire('dealer.home.training-compliance')
        ->assertSeeLivewire('dealer.home.note');
});

it('manager access dashboard when logged in', function (): void {
    $this->actingAs($this->manager)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertDontSee('OSHA Rating')
        ->assertSee('Courses')
        ->assertDontSeeLivewire('dealer.home.osha-stats')
        ->assertDontSeeLivewire('dealer.home.body-shop-stats')
        ->assertDontSeeLivewire('dealer.home.glba-stats')
        ->assertDontSeeLivewire('dealer.home.deal-jacket-stats')
        ->assertDontSeeLivewire('dealer.employee.completed-courses-stat')
        ->assertDontSeeLivewire('dealer.home.note')
        ->assertSeeLivewire('dealer.home.training-compliance')
        ->assertSeeLivewire('dealer.course.index');
});

it('consultant sees single-store widgets when current_store_id is null and only one store exists', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => null]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertSee('<title>'.$store->name.'</title>', false)
        ->assertSee('OSHA Rating')
        ->assertSee('IT Scans')
        ->assertSee('Manuals')
        ->assertSee('Audits')
        ->assertSee('Settings')
        ->assertSeeLivewire('dealer.home.osha-stats')
        ->assertSeeLivewire('dealer.home.body-shop-stats')
        ->assertSeeLivewire('dealer.home.glba-stats')
        ->assertSeeLivewire('dealer.home.deal-jacket-stats')
        ->assertSeeLivewire('dealer.home.training-compliance')
        ->assertSeeLivewire('dealer.home.note')
        ->assertDontSeeLivewire('dealer.home.group-rating')
        ->assertDontSeeLivewire('dealer.home.store-list');
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
        ->assertDontSee('OSHA Rating')
        ->assertDontSee('IT Scans')
        ->assertDontSee('Manuals')
        ->assertDontSee('Audits')
        ->assertDontSee('Ridgeback')
        ->assertDontSee('Settings')
        ->assertSeeLivewire('dealer.home.group-rating')
        ->assertSeeLivewire('dealer.home.store-list')
        ->assertSeeLivewire('dealer.home.training-compliance')
        ->assertDontSeeLivewire('dealer.home.osha-stats')
        ->assertDontSeeLivewire('dealer.home.body-shop-stats')
        ->assertDontSeeLivewire('dealer.home.glba-stats')
        ->assertDontSeeLivewire('dealer.home.deal-jacket-stats')
        ->assertDontSeeLivewire('dealer.home.note');
});

it('super-admin sees global settings in overview mode with multiple scoped stores', function (): void {
    $superAdmin = User::query()->create([
        'name' => 'Dashboard Super Admin',
        'email' => 'dashboard-super-admin@test.com',
        'password' => bcrypt('password'),
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
        ->assertSee('Global Settings')
        ->assertDontSee('Ridgeback');
});
