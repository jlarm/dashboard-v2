<?php

declare(strict_types=1);

use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    // Ensure multi-store mode so StoreIdentifierMiddleware doesn't auto-assign
    // current_store_id and trigger the /global-settings -> /settings redirect.
    Store::query()->create([
        'name' => 'Second Store',
        'slug' => 'second-store',
    ]);

    $this->consultant->update(['current_store_id' => null]);
});

describe('global settings index', function (): void {
    it('renders the inertia page for super-admin', function (): void {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super-admin');

        $this->actingAs($superAdmin)
            ->get(route('dealer.settings.global'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/settings/GlobalSettings')
                ->where('section', 'general')
                ->has('stores'));
    });

    it('renders for consultants', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.settings.global'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/settings/GlobalSettings')
                ->where('section', 'general'));
    });

    it('forbids non-qualifying roles', function (string $role): void {
        $this->consultant->syncRoles($role);

        $this->actingAs($this->consultant)
            ->get(route('dealer.settings.global'))
            ->assertForbidden();
    })->with(['Owner', 'GM', 'CFO', 'Manager', 'Employee']);

    it('redirects guests to login', function (): void {
        $this->get(route('dealer.settings.global'))
            ->assertRedirect(route('dealer.login'));
    });

    it('redirects to /settings when the user has a current_store_id', function (): void {
        $store = Store::query()->firstOrFail();
        $this->consultant->update(['current_store_id' => $store->id]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.settings.global'))
            ->assertRedirect(route('dealer.dealer.settings'));
    });

    it('still renders global settings when the user has no current_store_id', function (): void {
        $this->consultant->update(['current_store_id' => null]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.settings.global'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('tenant/settings/GlobalSettings'));
    });

    it('renders the course-management section', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.settings.global.course-management'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/settings/GlobalSettings')
                ->where('section', 'course-management')
                ->has('courses'));
    });

    it('renders the reset-courses section with users', function (): void {
        $employee = User::factory()->create(['name' => 'Reset Employee']);
        $employee->assignRole('Employee');
        $employee->stores()->sync([Store::query()->firstOrFail()->id]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.settings.global.reset-courses'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/settings/GlobalSettings')
                ->where('section', 'reset-courses')
                ->has('users'));
    });

    it('filters reset-courses users by search', function (): void {
        $store = Store::query()->firstOrFail();

        $jane = User::factory()->create(['name' => 'Jane Reset', 'email' => 'jane.reset@test.com']);
        $jane->assignRole('Employee');
        $jane->stores()->sync([$store->id]);

        $john = User::factory()->create(['name' => 'John Reset', 'email' => 'john.reset@test.com']);
        $john->assignRole('Employee');
        $john->stores()->sync([$store->id]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.settings.global.reset-courses', ['search' => 'Jane']))
            ->assertInertia(function ($page): void {
                $names = collect($page->toArray()['props']['users'])->pluck('name');
                expect($names)->toContain('Jane Reset')->not->toContain('John Reset');
            });
    });

});

describe('global settings store toggles', function (): void {
    it('toggles store course-not-taken notifications', function (): void {
        $store = Store::query()->firstOrFail();
        $store->update(['courses_not_taken_notification' => false]);

        $this->actingAs($this->consultant)
            ->post(route('dealer.settings.global.stores.notifications', $store))
            ->assertRedirect();

        expect((bool) $store->fresh()->courses_not_taken_notification)->toBeTrue();
    });

    it('toggles store remediation settings', function (): void {
        $store = Store::query()->firstOrFail();

        $this->actingAs($this->consultant)
            ->post(route('dealer.settings.global.stores.remediations', $store))
            ->assertRedirect();

        expect((bool) $store->fresh()->remediationSettings?->active)->toBeTrue();

        $this->actingAs($this->consultant)
            ->post(route('dealer.settings.global.stores.remediations', $store))
            ->assertRedirect();

        expect((bool) $store->fresh()->remediationSettings?->active)->toBeFalse();
    });

    it('forbids managers from toggling store notifications', function (): void {
        $store = Store::query()->firstOrFail();

        $this->actingAs($this->manager)
            ->post(route('dealer.settings.global.stores.notifications', $store))
            ->assertForbidden();
    });
});

describe('global settings optional course toggle', function (): void {
    it('toggles a course optional flag', function (): void {
        $course = Course::query()->create([
            'slug' => 'sample-course-toggle',
            'name' => 'Sample Course Toggle',
            'optional' => false,
            'slides' => [],
            'questions' => [],
        ]);

        $this->actingAs($this->consultant)
            ->patch(route('dealer.settings.global.courses.optional', $course))
            ->assertRedirect();

        expect((bool) $course->fresh()->optional)->toBeTrue();
    });

    it('forbids managers from toggling optional courses', function (): void {
        $course = Course::query()->create([
            'slug' => 'sample-course-forbid',
            'name' => 'Sample Course Forbid',
            'optional' => false,
            'slides' => [],
            'questions' => [],
        ]);

        $this->actingAs($this->manager)
            ->patch(route('dealer.settings.global.courses.optional', $course))
            ->assertForbidden();
    });
});

describe('global settings reset courses', function (): void {
    it('resets courses for everyone', function (): void {
        $store = Store::query()->firstOrFail();

        $course = Course::query()->create([
            'slug' => 'reset-everyone-course',
            'name' => 'Reset Everyone Course',
            'slides' => [],
            'questions' => [],
        ]);

        $jane = User::factory()->create();
        $jane->assignRole('Employee');
        $jane->stores()->sync([$store->id]);

        CourseResults::query()->create([
            'user_id' => $jane->id,
            'course_id' => $course->id,
            'passed' => true,
            'percentage' => 100,
        ]);

        Bus::fake();

        $this->actingAs($this->consultant)
            ->post(route('dealer.settings.global.reset-courses.run'), [
                'mode' => 'everyone',
                'user_ids' => [],
            ])
            ->assertRedirect();

        expect(CourseResults::query()->where('user_id', $jane->id)->exists())->toBeFalse();
    });

    it('resets courses for selected users only', function (): void {
        $store = Store::query()->firstOrFail();

        $course = Course::query()->create([
            'slug' => 'reset-selected-course',
            'name' => 'Reset Selected Course',
            'slides' => [],
            'questions' => [],
        ]);

        $jane = User::factory()->create();
        $jane->assignRole('Employee');
        $jane->stores()->sync([$store->id]);

        $john = User::factory()->create();
        $john->assignRole('Employee');
        $john->stores()->sync([$store->id]);

        CourseResults::query()->create(['user_id' => $jane->id, 'course_id' => $course->id, 'passed' => true, 'percentage' => 100]);
        CourseResults::query()->create(['user_id' => $john->id, 'course_id' => $course->id, 'passed' => true, 'percentage' => 100]);

        Bus::fake();

        $this->actingAs($this->consultant)
            ->post(route('dealer.settings.global.reset-courses.run'), [
                'mode' => 'selected-users',
                'user_ids' => [$jane->id],
            ])
            ->assertRedirect();

        expect(CourseResults::query()->where('user_id', $jane->id)->exists())->toBeFalse();
        expect(CourseResults::query()->where('user_id', $john->id)->exists())->toBeTrue();
    });

    it('requires at least one selected user in selected-users mode', function (): void {
        $this->actingAs($this->consultant)
            ->post(route('dealer.settings.global.reset-courses.run'), [
                'mode' => 'selected-users',
                'user_ids' => [],
            ])
            ->assertSessionHasErrors('user_ids');
    });

    it('logs the reset activity', function (): void {
        Bus::fake();

        $this->actingAs($this->consultant)
            ->post(route('dealer.settings.global.reset-courses.run'), [
                'mode' => 'everyone',
                'user_ids' => [],
            ])
            ->assertRedirect();

        $log = Activity::query()
            ->where('description', 'All employee course results reset')
            ->latest('id')
            ->first();

        expect($log)->not->toBeNull();
        expect($log->properties->get('reset_scope'))->toBe('everyone');
    });

    it('forbids managers from resetting', function (): void {
        $this->actingAs($this->manager)
            ->post(route('dealer.settings.global.reset-courses.run'), [
                'mode' => 'everyone',
                'user_ids' => [],
            ])
            ->assertForbidden();
    });
});
