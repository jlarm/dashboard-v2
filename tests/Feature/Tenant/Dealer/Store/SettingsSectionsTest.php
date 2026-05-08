<?php

declare(strict_types=1);

use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

it('renders the inertia store settings page on the default route', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dealer.settings'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('tenant/settings/StoreSettings')
            ->where('section', 'general')
            ->where('store.id', $store->id)
            ->has('can.update'));
});

it('renders each section route with the correct section prop', function (string $route, string $section): void {
    $store = Store::query()->firstOrFail();

    $superAdmin = User::factory()->create(['current_store_id' => $store->id]);
    $superAdmin->assignRole('super-admin');
    $superAdmin->stores()->sync([$store->id]);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    $this->actingAs($superAdmin)
        ->get(route($route))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('tenant/settings/StoreSettings')
            ->where('section', $section));
})->with([
    'managers' => ['dealer.dealer.settings.managers', 'managers'],
    'compliance' => ['dealer.dealer.settings.compliance', 'compliance'],
    'reset-courses' => ['dealer.dealer.settings.reset-courses', 'reset-courses'],
    'ridgeback' => ['dealer.dealer.settings.ridgeback', 'ridgeback'],
]);

it('forbids the ridgeback settings page for users without dealership creation access', function (): void {
    $store = Store::query()->firstOrFail();

    $qualifiedIndividual = User::factory()->create(['current_store_id' => $store->id]);
    $qualifiedIndividual->assignRole('Qualified Individual');
    $qualifiedIndividual->stores()->sync([$store->id]);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    $this->actingAs($qualifiedIndividual)
        ->get(route('dealer.dealer.settings.ridgeback'))
        ->assertForbidden();
});

it('forbids the reset courses settings page for users without dealership creation access', function (): void {
    $store = Store::query()->firstOrFail();

    $qualifiedIndividual = User::factory()->create(['current_store_id' => $store->id]);
    $qualifiedIndividual->assignRole('Qualified Individual');
    $qualifiedIndividual->stores()->sync([$store->id]);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    $this->actingAs($qualifiedIndividual)
        ->get(route('dealer.dealer.settings.reset-courses'))
        ->assertForbidden();
});

describe('general section update', function (): void {
    it('saves store, remediation, and global phishing settings in one request', function (): void {
        $store = Store::query()->firstOrFail();
        $this->consultant->update(['current_store_id' => $store->id]);

        $this->actingAs($this->consultant)
            ->patch(route('dealer.dealer.settings.general.update', $store), [
                'name' => 'Renamed Dealership',
                'address' => '500 Updated Way',
                'city' => 'Detroit',
                'state' => 'MI',
                'postal_code' => '48201',
                'phone' => '313-555-1234',
                'website' => 'https://renamed.test',
                'active_monitoring' => true,
                'monitoring_start_date' => '2026-01-01',
                'courses_not_taken_notification' => true,
                'videos' => false,
                'remediations_active' => true,
                'remediation_notifications' => true,
                'remediation_frequency' => 'weekly',
                'phishing_active' => true,
                'phishing_token' => 'abc-token',
                'phishing_ip' => '1.2.3.4',
            ])
            ->assertRedirect()
            ->assertSessionHas('flash.success');

        $store->refresh();
        expect($store->name)->toBe('Renamed Dealership')
            ->and($store->city)->toBe('Detroit')
            ->and((bool) $store->active_monitoring)->toBeTrue()
            ->and($store->videos)->toBeFalse();

        $store->loadMissing('remediationSettings');
        expect($store->remediationSettings->active)->toBeTrue()
            ->and($store->remediationSettings->notifications)->toBeTrue()
            ->and($store->remediationSettings->frequency->value)->toBe('weekly');

        $globalSetting = GlobalSetting::query()->firstOrFail();
        expect($globalSetting->phishing_active)->toBeTrue()
            ->and($globalSetting->phishing_token)->toBe('abc-token')
            ->and($globalSetting->phishing_ip)->toBe('1.2.3.4');
    });

    it('requires frequency when remediation notifications are enabled', function (): void {
        $store = Store::query()->firstOrFail();
        $this->consultant->update(['current_store_id' => $store->id]);

        $this->actingAs($this->consultant)
            ->patch(route('dealer.dealer.settings.general.update', $store), [
                'name' => $store->name,
                'active_monitoring' => false,
                'courses_not_taken_notification' => false,
                'videos' => false,
                'remediations_active' => true,
                'remediation_notifications' => true,
                'remediation_frequency' => null,
                'phishing_active' => false,
            ])
            ->assertSessionHasErrors('remediation_frequency');
    });

    it('forbids managers from saving general settings', function (): void {
        $store = Store::query()->firstOrFail();
        $this->manager->update(['current_store_id' => $store->id]);

        $this->actingAs($this->manager)
            ->patch(route('dealer.dealer.settings.general.update', $store), [
                'name' => 'Hijacked Name',
                'active_monitoring' => false,
                'courses_not_taken_notification' => false,
                'videos' => false,
                'remediations_active' => false,
                'remediation_notifications' => false,
                'phishing_active' => false,
            ])
            ->assertForbidden();
    });
});
