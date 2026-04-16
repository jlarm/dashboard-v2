<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Home\TrainingCompliance;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\AlertCenterService;
use App\Services\UserCourseService;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

it('shows employee with completed state-specific course as compliant, not missing a course', function (): void {
    $store = Store::query()->firstOrFail();
    $store->update(['state' => 'california']);

    // Use a unique role so pre-seeded Employee courses don't interfere
    $uniqueRole = Role::query()->create(['name' => 'TestStateRole-'.uniqid(), 'guard_name' => 'web']);
    $slug = 'general-harassment-'.uniqid();

    $generalCourse = Course::query()->create([
        'name' => 'General Harassment '.uniqid(),
        'slug' => $slug,
        'slides' => [],
        'questions' => [],
        'optional' => false,
        'years_expires' => 1,
        'states_required' => null,
        'replaces_course_slugs' => null,
    ]);
    $generalCourse->roles()->attach($uniqueRole->id);

    $californiaCourse = Course::query()->create([
        'name' => 'California Harassment '.uniqid(),
        'slug' => 'ca-harassment-'.uniqid(),
        'slides' => [],
        'questions' => [],
        'optional' => false,
        'years_expires' => 1,
        'states_required' => ['california'],
        'replaces_course_slugs' => [$slug],
    ]);
    $californiaCourse->roles()->attach($uniqueRole->id);

    $employee = User::query()->create([
        'name' => 'Widget California Employee',
        'email' => 'widget-ca-employee@test.com',
        'password' => bcrypt('password'),
    ]);
    $employee->assignRole($uniqueRole);
    $employee->stores()->attach($store->id);

    // Employee completed the California-specific course — should be fully compliant
    CourseResults::query()->create([
        'user_id' => $employee->id,
        'course_id' => $californiaCourse->id,
        'passed' => 1,
        'percentage' => 100,
        'created_at' => now()->subMonths(1),
        'updated_at' => now()->subMonths(1),
    ]);

    app()->instance('scopedStoreIds', collect([$store->id]));

    // Clear singleton cache so new courses/role are picked up
    app(UserCourseService::class)->clearAllCaches();

    // Use AlertCenterService directly so only our test employee is in scope
    $service = app(AlertCenterService::class);
    $users = $service->scopedEmployeeQuery($this->consultant)->where('users.id', $employee->id)->get();
    $summaries = $service->summarizeUsers($users);
    $summary = $summaries->get($employee->id);

    // The state should be detected from the loaded stores relation
    $loadedUser = $users->first();
    expect($loadedUser->stores->pluck('state')->filter()->first())->toBe('california');

    // The state-specific CA course should replace the general one in the assigned course list
    $userCourseService = app(UserCourseService::class);
    $courseIds = $userCourseService->getCourseIds($loadedUser);

    expect($courseIds)->toContain($californiaCourse->id);
    expect($courseIds)->not->toContain($generalCourse->id);

    // The California course completion should be counted as valid — not missing
    expect($summary['valid_completed'])->toBeGreaterThanOrEqual(1);
    expect(in_array($californiaCourse->id, $courseIds, true))->toBeTrue();
});

it('renders compliance totals and priority training alerts for the current store scope', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    $employeeRole = Role::query()->where('name', 'Employee')->firstOrFail();
    $course = Course::query()->create([
        'name' => 'Widget Compliance '.uniqid(),
        'slug' => 'widget-compliance-'.uniqid(),
        'slides' => [],
        'questions' => [],
        'optional' => false,
        'years_expires' => 1,
    ]);
    $course->roles()->attach($employeeRole->id);

    $overdueEmployee = User::query()->create([
        'name' => 'Widget Overdue Employee',
        'email' => 'widget-overdue@test.com',
        'password' => bcrypt('password'),
    ]);
    $overdueEmployee->assignRole('Employee');
    $overdueEmployee->stores()->attach($store->id);

    $expiringSoonEmployee = User::query()->create([
        'name' => 'Widget Expiring Employee',
        'email' => 'widget-expiring@test.com',
        'password' => bcrypt('password'),
    ]);
    $expiringSoonEmployee->assignRole('Employee');
    $expiringSoonEmployee->stores()->attach($store->id);

    $compliantEmployee = User::query()->create([
        'name' => 'Widget Compliant Employee',
        'email' => 'widget-compliant@test.com',
        'password' => bcrypt('password'),
    ]);
    $compliantEmployee->assignRole('Employee');
    $compliantEmployee->stores()->attach($store->id);

    CourseResults::query()->create([
        'user_id' => $overdueEmployee->id,
        'course_id' => $course->id,
        'passed' => 1,
        'percentage' => 100,
        'created_at' => now()->subYears(2),
        'updated_at' => now()->subYears(2),
    ]);

    CourseResults::query()->create([
        'user_id' => $expiringSoonEmployee->id,
        'course_id' => $course->id,
        'passed' => 1,
        'percentage' => 100,
        'created_at' => now()->subYear()->addDays(10),
        'updated_at' => now()->subYear()->addDays(10),
    ]);

    CourseResults::query()->create([
        'user_id' => $compliantEmployee->id,
        'course_id' => $course->id,
        'passed' => 1,
        'percentage' => 100,
        'created_at' => now()->subMonths(1),
        'updated_at' => now()->subMonths(1),
    ]);

    app()->instance('currentStore', $store->id);
    app()->instance('scopedStoreIds', collect([$store->id]));

    Livewire::actingAs($this->consultant)
        ->test(TrainingCompliance::class)
        ->call('loadStats')
        ->assertSee('Training Compliance Snapshot')
        ->assertSee('Overdue')
        ->assertSee('At Risk')
        ->assertSee('Priority Alerts')
        ->assertSee('Widget Overdue Employee')
        ->assertSee('Widget Expiring Employee')
        ->assertSee('Widget Compliant Employee');
});
