<?php

declare(strict_types=1);

use App\Domain\Tenant\Compliance\Queries\CalculateExpiredTraining;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\UserCourseService;
use Spatie\Permission\Models\Role;

it('returns zero counts when no eligible employees exist', function (): void {
    $store = Store::query()->firstOrFail();

    $result = resolve(CalculateExpiredTraining::class)->handleForStore($store);

    expect($result)->toBe(['count' => 0, 'expiring_soon_count' => 0]);
});

it('counts a course whose passing result is past expiration as expired', function (): void {
    [$store, $employee, $course] = expiredTrainingFixture();

    CourseResults::query()->create([
        'user_id' => $employee->id,
        'course_id' => $course->id,
        'passed' => 1,
        'percentage' => 100,
        'created_at' => now()->subYears(2),
        'updated_at' => now()->subYears(2),
    ]);

    resolve(UserCourseService::class)->clearAllCaches();

    $result = resolve(CalculateExpiredTraining::class)->handleForStore($store);

    expect($result['count'])->toBe(1);
    expect($result['expiring_soon_count'])->toBe(0);
});

it('counts a course expiring within 30 days as expiring_soon, not expired', function (): void {
    [$store, $employee, $course] = expiredTrainingFixture();

    // years_expires = 1; passed 11 months and 20 days ago → expires in ~10 days.
    CourseResults::query()->create([
        'user_id' => $employee->id,
        'course_id' => $course->id,
        'passed' => 1,
        'percentage' => 100,
        'created_at' => now()->subYear()->addDays(10),
        'updated_at' => now()->subYear()->addDays(10),
    ]);

    resolve(UserCourseService::class)->clearAllCaches();

    $result = resolve(CalculateExpiredTraining::class)->handleForStore($store);

    expect($result['count'])->toBe(0);
    expect($result['expiring_soon_count'])->toBe(1);
});

it('counts a fresh passing result as neither expired nor expiring_soon', function (): void {
    [$store, $employee, $course] = expiredTrainingFixture();

    CourseResults::query()->create([
        'user_id' => $employee->id,
        'course_id' => $course->id,
        'passed' => 1,
        'percentage' => 100,
        'created_at' => now()->subWeek(),
        'updated_at' => now()->subWeek(),
    ]);

    resolve(UserCourseService::class)->clearAllCaches();

    $result = resolve(CalculateExpiredTraining::class)->handleForStore($store);

    expect($result['count'])->toBe(0);
    expect($result['expiring_soon_count'])->toBe(0);
});

it('counts a multi-store user once when aggregating across stores', function (): void {
    [$storeA, $employee, $course] = expiredTrainingFixture();

    $storeB = Store::query()->create(['name' => 'Other '.uniqid(), 'slug' => 'other-'.uniqid()]);
    $employee->stores()->attach($storeB->id);

    CourseResults::query()->create([
        'user_id' => $employee->id,
        'course_id' => $course->id,
        'passed' => 1,
        'percentage' => 100,
        'created_at' => now()->subYears(2),
        'updated_at' => now()->subYears(2),
    ]);

    resolve(UserCourseService::class)->clearAllCaches();

    $perStoreA = resolve(CalculateExpiredTraining::class)->handleForStore($storeA);
    $perStoreB = resolve(CalculateExpiredTraining::class)->handleForStore($storeB);
    $across = resolve(CalculateExpiredTraining::class)->handleForStores([$storeA->id, $storeB->id]);
    $tenantWide = resolve(CalculateExpiredTraining::class)->handleForTenant();

    // Per-store rows show the user in each store (sum would be 2)…
    expect($perStoreA['count'])->toBe(1);
    expect($perStoreB['count'])->toBe(1);

    // …but the deduped aggregations count Alice once.
    expect($across['count'])->toBe(1);
    expect($tenantWide['count'])->toBe(1);
});

/**
 * @return array{0: Store, 1: User, 2: Course}
 */
function expiredTrainingFixture(): array
{
    $store = Store::query()->firstOrFail();

    $role = Role::query()->create([
        'name' => 'ExpiredTrainingRole-'.uniqid(),
        'guard_name' => 'web',
    ]);

    $course = Course::query()->create([
        'name' => 'Expired Training Course '.uniqid(),
        'slug' => 'expired-training-'.uniqid(),
        'slides' => [],
        'questions' => [],
        'optional' => false,
        'years_expires' => 1,
    ]);
    $course->roles()->attach($role->id);

    $employee = User::query()->create([
        'name' => 'Expired Training Employee '.uniqid(),
        'email' => 'expired-'.uniqid().'@test.com',
        'password' => bcrypt('password'),
    ]);
    $employee->assignRole($role);
    $employee->stores()->attach($store->id);

    return [$store, $employee, $course];
}
