<?php

declare(strict_types=1);

use App\Domain\Tenant\Compliance\Queries\CalculateTrainingPillar;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\UserCourseService;
use Spatie\Permission\Models\Role;

it('marks the pillar as not applicable when no employees belong to the store', function (): void {
    $store = Store::query()->firstOrFail();

    $pillar = resolve(CalculateTrainingPillar::class)->handle($store);

    expect($pillar->applicable)->toBeFalse();
});

it('counts a recent passing result as a completed required course', function (): void {
    [$store, $employee, $course] = trainingPillarFixture();

    resolve(UserCourseService::class)->clearAllCaches();
    $baseline = resolve(CalculateTrainingPillar::class)->handle($store);

    CourseResults::query()->create([
        'user_id' => $employee->id,
        'course_id' => $course->id,
        'passed' => 1,
        'percentage' => 100,
        'created_at' => now()->subMonth(),
        'updated_at' => now()->subMonth(),
    ]);

    resolve(UserCourseService::class)->clearAllCaches();
    $afterCompletion = resolve(CalculateTrainingPillar::class)->handle($store);

    expect($afterCompletion->applicable)->toBeTrue();
    expect($afterCompletion->score)->toBeGreaterThan($baseline->score);
    expect($afterCompletion->breakdown['valid_completed'])->toBeGreaterThan($baseline->breakdown['valid_completed']);
});

it('drops below 100 when courses are expired', function (): void {
    [$store, $employee, $course] = trainingPillarFixture();

    CourseResults::query()->create([
        'user_id' => $employee->id,
        'course_id' => $course->id,
        'passed' => 1,
        'percentage' => 100,
        'created_at' => now()->subYears(2),
        'updated_at' => now()->subYears(2),
    ]);

    resolve(UserCourseService::class)->clearAllCaches();

    $pillar = resolve(CalculateTrainingPillar::class)->handle($store);

    expect($pillar->applicable)->toBeTrue();
    expect($pillar->score)->toBeLessThan(100.0);
    expect($pillar->breakdown['expired'])->toBeGreaterThanOrEqual(1);
});

/**
 * @return array{0: Store, 1: User, 2: Course}
 */
function trainingPillarFixture(): array
{
    $store = Store::query()->firstOrFail();

    $role = Role::query()->create([
        'name' => 'TrainingPillarRole-'.uniqid(),
        'guard_name' => 'web',
    ]);

    $course = Course::query()->create([
        'name' => 'Training Pillar Course '.uniqid(),
        'slug' => 'training-pillar-'.uniqid(),
        'slides' => [],
        'questions' => [],
        'optional' => false,
        'years_expires' => 1,
    ]);
    $course->roles()->attach($role->id);

    $employee = User::query()->create([
        'name' => 'Pillar Employee '.uniqid(),
        'email' => 'pillar-'.uniqid().'@test.com',
        'password' => bcrypt('password'),
    ]);
    $employee->assignRole($role);
    $employee->stores()->attach($store->id);

    return [$store, $employee, $course];
}
