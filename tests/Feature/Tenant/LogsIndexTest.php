<?php

declare(strict_types=1);

use App\Models\User;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\PermissionRegistrar;

describe('Logs Index Page - Authorization', function (): void {
    beforeEach(function (): void {
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
    });

    it('allows super-admins', function (): void {
        $user = User::factory()->create();
        $user->assignRole('super-admin');

        $this->actingAs($user)
            ->get(route('dealer.logs.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('tenant/log/Index'));
    });

    it('allows Consultants', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.logs.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('tenant/log/Index'));
    });

    it('denies Owners', function (): void {
        $user = User::factory()->create();
        $user->assignRole('Owner');

        $this->actingAs($user)
            ->get(route('dealer.logs.index'))
            ->assertForbidden();
    });

    it('denies Managers', function (): void {
        $user = User::factory()->create();
        $user->assignRole('Manager');

        $this->actingAs($user)
            ->get(route('dealer.logs.index'))
            ->assertForbidden();
    });

    it('denies Employees', function (): void {
        $user = User::factory()->create();
        $user->assignRole('Employee');

        $this->actingAs($user)
            ->get(route('dealer.logs.index'))
            ->assertForbidden();
    });

    it('redirects guests to login', function (): void {
        $this->get(route('dealer.logs.index'))
            ->assertRedirect(route('dealer.login'));
    });
});

describe('Logs Index Page - Listing', function (): void {
    it('returns the latest activity logs paginated', function (): void {
        $this->actingAs($this->consultant);

        // Run a request first so any activity from auth bootstrapping is settled,
        // then reset the table to a known state.
        $this->get(route('dealer.logs.index'));
        Activity::query()->delete();

        foreach (range(1, 30) as $i) {
            activity()
                ->causedBy($this->consultant)
                ->log("Activity {$i}");
        }

        $this->get(route('dealer.logs.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/log/Index')
                ->has('logs.data', 25)
                ->where('logs.meta.total', 30)
                ->where('logs.meta.current_page', 1)
                ->where('logs.data.0.description', 'Activity 30'));

        $this->get(route('dealer.logs.index', ['page' => 2]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('logs.data', 5)
                ->where('logs.meta.current_page', 2));
    });

    it('filters logs by search term', function (): void {
        $this->actingAs($this->consultant);

        Activity::query()->delete();

        activity()->causedBy($this->consultant)->log('Brake check completed');
        activity()->causedBy($this->consultant)->log('Oil change scheduled');

        $this->get(route('dealer.logs.index', ['search' => 'brake']))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('logs.data', 1)
                ->where('logs.data.0.description', 'Brake check completed')
                ->where('filters.search', 'brake'));
    });
});

describe('Logs Show Endpoint', function (): void {
    it('returns the activity payload', function (): void {
        $activity = activity()
            ->causedBy($this->consultant)
            ->log('Test activity');

        $this->actingAs($this->consultant)
            ->getJson(route('dealer.logs.show', $activity))
            ->assertOk()
            ->assertJsonPath('data.id', $activity->id)
            ->assertJsonPath('data.description', 'Test activity')
            ->assertJsonPath('data.causer_name', $this->consultant->name);
    });

    it('rejects non-privileged users', function (): void {
        $activity = activity()->log('Restricted');

        $employee = User::factory()->create();
        $employee->assignRole('Employee');

        $this->actingAs($employee)
            ->getJson(route('dealer.logs.show', $activity))
            ->assertForbidden();
    });
});
