<?php

declare(strict_types=1);

use App\Domain\Tenant\Compliance\Data\TrainingComplianceAlertData;
use App\Domain\Tenant\Compliance\Queries\GetTrainingComplianceSnapshot;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\UserCourseService;
use Spatie\Permission\Models\Role;

it('returns an empty snapshot when no store ids are scoped', function (): void {
    $snapshot = resolve(GetTrainingComplianceSnapshot::class)->handleForStores([]);

    expect($snapshot->employees)->toBe(0);
    expect($snapshot->priority_alerts)->toBe([]);
});

it('excludes super-admin and Consultant from employee counts', function (): void {
    $store = Store::query()->firstOrFail();

    $consultant = User::query()->create([
        'name' => 'Snapshot Consultant '.uniqid(),
        'email' => 'snapshot-consultant-'.uniqid().'@test.com',
        'password' => bcrypt('password'),
    ]);
    $consultant->assignRole(Role::query()->where('name', 'Consultant')->firstOrFail());
    $consultant->stores()->attach($store->id);

    $snapshot = resolve(GetTrainingComplianceSnapshot::class)->handleForStores([$store->id]);

    expect($snapshot->employees)->toBe(0);
});

it('buckets users by status and surfaces non-compliant employees in priority alerts', function (): void {
    [$store, $compliantEmployee, $course] = snapshotFixture('compliant');

    CourseResults::query()->create([
        'user_id' => $compliantEmployee->id,
        'course_id' => $course->id,
        'passed' => 1,
        'percentage' => 100,
        'created_at' => now()->subWeek(),
        'updated_at' => now()->subWeek(),
    ]);
    markAssignedCoursesCurrent($compliantEmployee);

    $overdueEmployee = User::query()->create([
        'name' => 'Snapshot Overdue '.uniqid(),
        'email' => 'snapshot-overdue-'.uniqid().'@test.com',
        'password' => bcrypt('password'),
    ]);
    foreach ($compliantEmployee->roles as $role) {
        $overdueEmployee->assignRole($role);
    }
    $overdueEmployee->stores()->attach($store->id);
    CourseResults::query()->create([
        'user_id' => $overdueEmployee->id,
        'course_id' => $course->id,
        'passed' => 1,
        'percentage' => 100,
        'created_at' => now()->subYears(2),
        'updated_at' => now()->subYears(2),
    ]);

    $atRiskEmployee = User::query()->create([
        'name' => 'Snapshot At Risk '.uniqid(),
        'email' => 'snapshot-at-risk-'.uniqid().'@test.com',
        'password' => bcrypt('password'),
    ]);
    foreach ($compliantEmployee->roles as $role) {
        $atRiskEmployee->assignRole($role);
    }
    $atRiskEmployee->stores()->attach($store->id);

    resolve(UserCourseService::class)->clearAllCaches();

    $snapshot = resolve(GetTrainingComplianceSnapshot::class)->handleForStores([$store->id]);

    expect($snapshot->employees)->toBe(3);
    expect($snapshot->overdue)->toBe(1);
    expect($snapshot->at_risk)->toBeGreaterThanOrEqual(1);
    expect($snapshot->compliant)->toBeGreaterThanOrEqual(0);

    expect($snapshot->priority_alerts)->not->toBeEmpty();
    expect($snapshot->priority_alerts[0]->status)->toBe('overdue');

    $alertSlugs = array_map(static fn (TrainingComplianceAlertData $alert): string => $alert->user_slug, $snapshot->priority_alerts);
    expect($alertSlugs)->toContain($overdueEmployee->slug);
    expect($alertSlugs)->not->toContain($compliantEmployee->slug);
});

it('sorts unassigned employees above overdue and at risk', function (): void {
    [$store, $overdueEmployee, $course] = snapshotFixture('order');

    CourseResults::query()->create([
        'user_id' => $overdueEmployee->id,
        'course_id' => $course->id,
        'passed' => 1,
        'percentage' => 100,
        'created_at' => now()->subYears(2),
        'updated_at' => now()->subYears(2),
    ]);

    $unassignedEmployee = User::query()->create([
        'name' => 'Snapshot Unassigned '.uniqid(),
        'email' => 'snapshot-unassigned-'.uniqid().'@test.com',
        'password' => bcrypt('password'),
    ]);
    // No roles, so UserCourseService returns no required courses → status unassigned.
    $unassignedEmployee->stores()->attach($store->id);

    resolve(UserCourseService::class)->clearAllCaches();

    $snapshot = resolve(GetTrainingComplianceSnapshot::class)->handleForStores([$store->id]);

    expect($snapshot->priority_alerts[0]->status)->toBe('unassigned');
    expect($snapshot->priority_alerts[0]->user_slug)->toBe($unassignedEmployee->slug);
});

/**
 * @return array{0: Store, 1: User, 2: Course}
 */
function snapshotFixture(string $tag): array
{
    $store = Store::query()->firstOrFail();

    $role = Role::query()->create([
        'name' => 'SnapshotRole-'.$tag.'-'.uniqid(),
        'guard_name' => 'web',
    ]);

    $course = Course::query()->create([
        'name' => 'Snapshot Course '.$tag.' '.uniqid(),
        'slug' => 'snapshot-'.$tag.'-'.uniqid(),
        'slides' => [],
        'questions' => [],
        'optional' => false,
        'years_expires' => 1,
    ]);
    $course->roles()->attach($role->id);

    $employee = User::query()->create([
        'name' => 'Snapshot Employee '.$tag.' '.uniqid(),
        'email' => 'snapshot-'.$tag.'-'.uniqid().'@test.com',
        'password' => bcrypt('password'),
    ]);
    $employee->assignRole($role);
    $employee->stores()->attach($store->id);

    return [$store, $employee, $course];
}

function markAssignedCoursesCurrent(User $user): void
{
    resolve(UserCourseService::class)->clearAllCaches();

    foreach (resolve(UserCourseService::class)->getCourseIds($user->fresh()) as $courseId) {
        if (CourseResults::query()->where('user_id', $user->id)->where('course_id', $courseId)->where('passed', 1)->exists()) {
            continue;
        }

        CourseResults::query()->create([
            'user_id' => $user->id,
            'course_id' => $courseId,
            'passed' => 1,
            'percentage' => 100,
            'created_at' => now()->subWeeks(2),
            'updated_at' => now()->subWeeks(2),
        ]);
    }

    resolve(UserCourseService::class)->clearAllCaches();
}
