<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Navigation\Main;
use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
    app()->instance('storesExist', true);
});

it('renders consultant navigation from the centralized menu definition', function (): void {
    $this->consultant->update(['current_store_id' => $this->store->id]);

    app()->instance('currentStoreModel', $this->store);

    $this->actingAs($this->consultant);

    Livewire::test(Main::class)
        ->assertSee('Home')
        ->assertDontSee('Courses')
        ->assertSee('Employees')
        ->assertSee('IT Scans')
        ->assertSee('Manuals')
        ->assertSee('Audits')
        ->assertSee('Settings')
        ->assertSee('Locations')
        ->assertSee('Logs');
});

it('renders manager navigation from the centralized menu definition', function (): void {
    $this->manager->stores()->sync([$this->store->id]);
    $this->manager->update(['current_store_id' => $this->store->id]);

    app()->instance('currentStoreModel', $this->store);

    $this->actingAs($this->manager);

    Livewire::test(Main::class)
        ->assertSee('Home')
        ->assertSee('Courses')
        ->assertSee('Employees')
        ->assertSee('IT Scans')
        ->assertDontSee('Manuals')
        ->assertSee('Audits')
        ->assertDontSee('Settings')
        ->assertDontSee('Locations')
        ->assertDontSee('Logs')
        ->assertSee('Documents')
        ->assertSee('SDS Sheets');
});

it('renders overview navigation for super-admins without a current store selection', function (): void {
    $superAdmin = User::query()->create([
        'name' => 'Navigation Super Admin',
        'email' => 'navigation-super-admin@test.com',
        'password' => bcrypt('password'),
        'current_store_id' => null,
    ]);
    $superAdmin->assignRole('super-admin');
    $superAdmin->stores()->sync([$this->store->id]);

    $otherStore = Store::query()->create([
        'name' => 'Navigation Super Admin Store B',
        'slug' => 'navigation-super-admin-store-b',
    ]);

    app()->forgetInstance('currentStoreModel');
    app()->instance('scopedStoreIds', collect([$this->store->id, $otherStore->id]));

    $this->actingAs($superAdmin);

    Livewire::test(Main::class)
        ->assertSee('Home')
        ->assertDontSee('href="https://test-tenant.localhost/settings"', false)
        ->assertSee('Global Settings')
        ->assertSee('Locations')
        ->assertSee('Logs')
        ->assertDontSee('IT Scans')
        ->assertDontSee('Ridgeback');
});

it('renders current-store navigation for super-admins through gate-based abilities', function (): void {
    $superAdmin = User::query()->create([
        'name' => 'Navigation Store Super Admin',
        'email' => 'navigation-store-super-admin@test.com',
        'password' => bcrypt('password'),
        'current_store_id' => $this->store->id,
    ]);
    $superAdmin->assignRole('super-admin');
    $superAdmin->stores()->sync([$this->store->id]);

    app()->instance('currentStoreModel', $this->store);

    $this->actingAs($superAdmin);

    Livewire::test(Main::class)
        ->assertSee('Employees')
        ->assertSee('IT Scans')
        ->assertSee('Manuals')
        ->assertSee('Ridgeback')
        ->assertSee('Settings');
});

it('marks employees as active on the deleted employees page', function (): void {
    $this->consultant->update(['current_store_id' => $this->store->id]);

    $response = $this->actingAs($this->consultant)
        ->get(route('dealer.employees.deleted'));

    $response->assertOk()
        ->assertSeeInOrder([
            'href="'.route('dealer.employees.index').'"',
            'bg-gray-100 text-gray-600 border-transparent group flex items-center rounded-lg py-1.5 px-2.5 text-[13px]"',
        ], false);
});
