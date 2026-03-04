<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();

    $this->superAdmin = User::query()->create([
        'name' => 'Global Settings Super Admin',
        'email' => 'global-settings-sections@test.com',
        'password' => bcrypt('password'),
    ]);
    $this->superAdmin->assignRole('super-admin');
    $this->superAdmin->stores()->sync([$this->store->id]);

    app()[PermissionRegistrar::class]->forgetCachedPermissions();
});

it('renders the global settings general page on the default route', function (): void {
    $this->actingAs($this->superAdmin)
        ->get(route('dealer.settings.global'))
        ->assertOk()
        ->assertSee('Store Course Notifications')
        ->assertSee('Course Management')
        ->assertSee('Reset Courses')
        ->assertSee('Phishing');
});

it('renders the course management global settings page on its own route', function (): void {
    $this->actingAs($this->superAdmin)
        ->get(route('dealer.settings.global.course-management'))
        ->assertOk()
        ->assertSee('Check off any course you would like to make optional in the dealership');
});

it('renders the phishing global settings page on its own route', function (): void {
    $this->actingAs($this->superAdmin)
        ->get(route('dealer.settings.global.phishing'))
        ->assertOk()
        ->assertSee('Phishing Simulations')
        ->assertSee('Token');
});

it('renders the reset courses global settings page on its own route', function (): void {
    $this->actingAs($this->superAdmin)
        ->get(route('dealer.settings.global.reset-courses'))
        ->assertOk()
        ->assertSee('Reset Courses')
        ->assertSee('Select Users');
});
