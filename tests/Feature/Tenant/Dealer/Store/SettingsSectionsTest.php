<?php

declare(strict_types=1);

use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Settings\EmployeeList;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
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
]);

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
    it('saves store and remediation settings in one request', function (): void {
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
                'courses_not_taken_notification' => true,
                'remediations_active' => true,
                'remediation_notifications' => true,
                'remediation_frequency' => 'weekly',
            ])
            ->assertRedirect()
            ->assertSessionHas('flash.success');

        $store->refresh();
        expect($store->name)->toBe('Renamed Dealership')
            ->and($store->city)->toBe('Detroit');

        $store->loadMissing('remediationSettings');
        expect($store->remediationSettings->active)->toBeTrue()
            ->and($store->remediationSettings->notifications)->toBeTrue()
            ->and($store->remediationSettings->frequency->value)->toBe('weekly');
    });

    it('requires frequency when remediation notifications are enabled', function (): void {
        $store = Store::query()->firstOrFail();
        $this->consultant->update(['current_store_id' => $store->id]);

        $this->actingAs($this->consultant)
            ->patch(route('dealer.dealer.settings.general.update', $store), [
                'name' => $store->name,
                'courses_not_taken_notification' => false,
                'remediations_active' => true,
                'remediation_notifications' => true,
                'remediation_frequency' => null,
            ])
            ->assertSessionHasErrors('remediation_frequency');
    });

    it('forbids managers from saving general settings', function (): void {
        $store = Store::query()->firstOrFail();
        $this->manager->update(['current_store_id' => $store->id]);

        $this->actingAs($this->manager)
            ->patch(route('dealer.dealer.settings.general.update', $store), [
                'name' => 'Hijacked Name',
                'courses_not_taken_notification' => false,
                'remediations_active' => false,
                'remediation_notifications' => false,
            ])
            ->assertForbidden();
    });
});

describe('managers section update', function (): void {
    it('creates the employee list when none exists', function (): void {
        $store = Store::query()->firstOrFail();
        $this->consultant->update(['current_store_id' => $store->id]);

        $this->actingAs($this->consultant)
            ->patch(route('dealer.dealer.settings.managers.update', $store), [
                'qualified_individual_name' => 'Quincy Q',
                'qualified_individual_phone' => '555-1234',
                'owner_name' => 'Olivia O',
                'owner_phone' => '555-9999',
            ])
            ->assertRedirect()
            ->assertSessionHas('flash.success');

        $list = EmployeeList::query()->where('store_id', $store->id)->firstOrFail();
        expect($list->qualified_individual_name)->toBe('Quincy Q')
            ->and($list->qualified_individual_phone)->toBe('555-1234')
            ->and($list->owner_name)->toBe('Olivia O')
            ->and($list->owner_phone)->toBe('555-9999')
            ->and($list->service_manager_name)->toBeNull();
    });

    it('updates an existing employee list', function (): void {
        $store = Store::query()->firstOrFail();
        EmployeeList::query()->create([
            'store_id' => $store->id,
            'general_manager_name' => 'Old GM',
            'general_manager_phone' => '111-1111',
        ]);

        $this->consultant->update(['current_store_id' => $store->id]);

        $this->actingAs($this->consultant)
            ->patch(route('dealer.dealer.settings.managers.update', $store), [
                'general_manager_name' => 'New GM',
                'general_manager_phone' => '222-2222',
            ])
            ->assertRedirect();

        $list = EmployeeList::query()->where('store_id', $store->id)->firstOrFail();
        expect($list->general_manager_name)->toBe('New GM')
            ->and($list->general_manager_phone)->toBe('222-2222');
    });

    it('forbids managers from saving the employee list', function (): void {
        $store = Store::query()->firstOrFail();
        $this->manager->update(['current_store_id' => $store->id]);

        $this->actingAs($this->manager)
            ->patch(route('dealer.dealer.settings.managers.update', $store), [
                'owner_name' => 'Hijacked',
            ])
            ->assertForbidden();
    });
});

describe('compliance section update', function (): void {
    it('saves compliance fields including array entries', function (): void {
        $store = Store::query()->firstOrFail();
        $this->consultant->update(['current_store_id' => $store->id]);

        $this->actingAs($this->consultant)
            ->patch(route('dealer.dealer.settings.compliance.update', $store), [
                'police_emergency_phone' => '911',
                'fire_emergency_phone' => '911',
                'firewall_company' => 'Acme Firewall',
                'ip_addresses' => ['192.168.1.1', '10.0.0.1'],
                'website_urls' => ['https://example.test'],
                'service_contracts' => ['Warranty Plus'],
                'tire_wheel' => ['T&W Premium'],
                'other_fi' => ['Other Plan'],
                'reinsurance' => true,
                'standard_dpp_rate' => '12.5',
            ])
            ->assertRedirect()
            ->assertSessionHas('flash.success');

        $store->refresh();
        expect($store->police_emergency_phone)->toBe('911')
            ->and($store->firewall_company)->toBe('Acme Firewall')
            ->and($store->ip_addresses)->toBe(['192.168.1.1', '10.0.0.1'])
            ->and($store->website_urls)->toBe(['https://example.test'])
            ->and($store->service_contracts)->toBe(['Warranty Plus'])
            ->and($store->tire_wheel)->toBe(['T&W Premium'])
            ->and($store->other_fi)->toBe(['Other Plan'])
            ->and((bool) $store->reinsurance)->toBeTrue()
            ->and((float) $store->standard_dpp_rate)->toBe(12.5);
    });

    it('rejects an out-of-range standard_dpp_rate', function (): void {
        $store = Store::query()->firstOrFail();
        $this->consultant->update(['current_store_id' => $store->id]);

        $this->actingAs($this->consultant)
            ->patch(route('dealer.dealer.settings.compliance.update', $store), [
                'reinsurance' => false,
                'standard_dpp_rate' => '500',
            ])
            ->assertSessionHasErrors('standard_dpp_rate');
    });

    it('strips empty array entries from list fields', function (): void {
        $store = Store::query()->firstOrFail();
        $this->consultant->update(['current_store_id' => $store->id]);

        $this->actingAs($this->consultant)
            ->patch(route('dealer.dealer.settings.compliance.update', $store), [
                'reinsurance' => false,
                'ip_addresses' => ['', '10.0.0.1', ''],
            ])
            ->assertRedirect();

        $store->refresh();
        expect($store->ip_addresses)->toBe(['10.0.0.1']);
    });

    it('forbids managers from saving compliance info', function (): void {
        $store = Store::query()->firstOrFail();
        $this->manager->update(['current_store_id' => $store->id]);

        $this->actingAs($this->manager)
            ->patch(route('dealer.dealer.settings.compliance.update', $store), [
                'reinsurance' => false,
            ])
            ->assertForbidden();
    });
});

describe('reset courses', function (): void {
    it('renders the reset-courses page when users at the store have course results', function (): void {
        $store = Store::query()->firstOrFail();

        $employee = User::factory()->create(['name' => 'Eddie Employee', 'current_store_id' => $store->id]);
        $employee->assignRole('Employee');
        $employee->stores()->sync([$store->id]);

        $course = Course::query()->firstOrFail();

        CourseResults::query()->create([
            'user_id' => $employee->id,
            'course_id' => $course->id,
            'passed' => true,
            'percentage' => 100,
        ]);

        $this->consultant->update(['current_store_id' => $store->id]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.dealer.settings.reset-courses'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/settings/StoreSettings')
                ->where('section', 'reset-courses'));
    });

    it('resets selected users at the current store', function (): void {
        Bus::fake();
        $store = Store::query()->firstOrFail();

        $employee = User::factory()->create(['current_store_id' => $store->id]);
        $employee->assignRole('Employee');
        $employee->stores()->sync([$store->id]);

        $course = Course::query()->firstOrFail();

        CourseResults::query()->create([
            'user_id' => $employee->id,
            'course_id' => $course->id,
            'passed' => true,
            'percentage' => 100,
        ]);

        $this->consultant->update(['current_store_id' => $store->id]);

        $this->actingAs($this->consultant)
            ->post(route('dealer.dealer.settings.reset-courses.run', $store), [
                'mode' => 'selected-users',
                'user_ids' => [$employee->id],
            ])
            ->assertRedirect()
            ->assertSessionHas('flash.success');

        expect(CourseResults::query()->where('user_id', $employee->id)->count())->toBe(0);
    });

    it('rejects selected-users mode with no user_ids', function (): void {
        $store = Store::query()->firstOrFail();
        $this->consultant->update(['current_store_id' => $store->id]);

        $this->actingAs($this->consultant)
            ->post(route('dealer.dealer.settings.reset-courses.run', $store), [
                'mode' => 'selected-users',
                'user_ids' => [],
            ])
            ->assertSessionHasErrors('user_ids');
    });

    it('forbids users without create-dealerships from resetting courses', function (): void {
        $store = Store::query()->firstOrFail();

        $qi = User::factory()->create(['current_store_id' => $store->id]);
        $qi->assignRole('Qualified Individual');
        $qi->stores()->sync([$store->id]);
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->actingAs($qi)
            ->post(route('dealer.dealer.settings.reset-courses.run', $store), [
                'mode' => 'everyone',
            ])
            ->assertForbidden();
    });
});
