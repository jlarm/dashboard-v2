<?php

declare(strict_types=1);

use App\Domain\Tenant\Compliance\Data\TrainingCompletionRowData;
use App\Domain\Tenant\Compliance\Queries\GetTrainingCompletionByDepartment;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Department;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\UserCourseService;
use Spatie\Permission\Models\Role;

it('returns an empty list when no store ids are scoped', function (): void {
    $rows = resolve(GetTrainingCompletionByDepartment::class)->handleForStores([]);

    expect($rows)->toBe([]);
});

it('reports 100% currency when every assigned course is current', function (): void {
    [$store, $employee] = trainingCompletionFixture('Sales');

    markAllCoursesCurrent($employee);

    $rows = resolve(GetTrainingCompletionByDepartment::class)->handleForStores([$store->id]);

    expect($rows[0])->toBeInstanceOf(TrainingCompletionRowData::class);
    expect($rows[0]->label)->toBe('All');
    expect($rows[0]->headcount)->toBe(1);
    expect($rows[0]->value)->toBe(100);

    $sales = collect($rows)->firstWhere('label', 'Sales');
    expect($sales)->not->toBeNull();
    expect($sales->value)->toBe(100);
    expect($sales->headcount)->toBe(1);
});

it('treats an employee with an expired course as not current', function (): void {
    [$store, $employee] = trainingCompletionFixture('Service');

    markAllCoursesCurrent($employee);

    $firstAssigned = (int) collect(resolve(UserCourseService::class)->getCourseIds($employee->fresh()))->first();
    CourseResults::query()->where('user_id', $employee->id)->where('course_id', $firstAssigned)->delete();
    CourseResults::query()->create([
        'user_id' => $employee->id,
        'course_id' => $firstAssigned,
        'passed' => 1,
        'percentage' => 100,
        'created_at' => now()->subYears(5),
        'updated_at' => now()->subYears(5),
    ]);

    resolve(UserCourseService::class)->clearAllCaches();

    $rows = resolve(GetTrainingCompletionByDepartment::class)->handleForStores([$store->id]);

    $service = collect($rows)->firstWhere('label', 'Service');
    expect($service->value)->toBe(0);
    expect($service->headcount)->toBe(1);
    expect($rows[0]->value)->toBe(0);
});

it('buckets employees by department and rounds the percentage', function (): void {
    [$store, $currentEmployee] = trainingCompletionFixture('Sales');
    markAllCoursesCurrent($currentEmployee);

    $department = Department::query()->where('name', 'Sales')->firstOrFail();
    $incompleteEmployee = User::query()->create([
        'name' => 'Currency Incomplete '.uniqid(),
        'email' => 'currency-incomplete-'.uniqid().'@test.com',
        'password' => bcrypt('password'),
        'department_id' => $department->id,
    ]);
    foreach ($currentEmployee->roles as $role) {
        $incompleteEmployee->assignRole($role);
    }
    $incompleteEmployee->stores()->attach($store->id);

    resolve(UserCourseService::class)->clearAllCaches();

    $rows = resolve(GetTrainingCompletionByDepartment::class)->handleForStores([$store->id]);

    $sales = collect($rows)->firstWhere('label', 'Sales');
    expect($sales->headcount)->toBe(2);
    expect($sales->value)->toBe(50);
    expect($rows[0]->headcount)->toBe(2);
    expect($rows[0]->value)->toBe(50);
});

it('excludes super-admin and Consultant users from the rollup', function (): void {
    [$store, $employee] = trainingCompletionFixture('Sales');
    markAllCoursesCurrent($employee);

    $consultant = User::query()->create([
        'name' => 'Consultant '.uniqid(),
        'email' => 'consultant-'.uniqid().'@test.com',
        'password' => bcrypt('password'),
    ]);
    $consultant->assignRole(Role::query()->where('name', 'Consultant')->firstOrFail());
    $consultant->stores()->attach($store->id);

    resolve(UserCourseService::class)->clearAllCaches();

    $rows = resolve(GetTrainingCompletionByDepartment::class)->handleForStores([$store->id]);

    expect($rows[0]->headcount)->toBe(1);
});

/**
 * @return array{0: Store, 1: User, 2: Course}
 */
function trainingCompletionFixture(string $departmentName): array
{
    $store = Store::query()->firstOrFail();

    $department = Department::query()->firstOrCreate(
        ['name' => $departmentName],
        ['slug' => str($departmentName)->slug()->value()],
    );

    $role = Role::query()->create([
        'name' => 'TrainingCompletionRole-'.uniqid(),
        'guard_name' => 'web',
    ]);

    $course = Course::query()->create([
        'name' => 'Training Currency Course '.uniqid(),
        'slug' => 'training-currency-'.uniqid(),
        'slides' => [],
        'questions' => [],
        'optional' => false,
        'years_expires' => 1,
    ]);
    $course->roles()->attach($role->id);
    $course->departments()->attach($department->id);

    $employee = User::query()->create([
        'name' => 'Currency Employee '.uniqid(),
        'email' => 'currency-'.uniqid().'@test.com',
        'password' => bcrypt('password'),
        'department_id' => $department->id,
    ]);
    $employee->assignRole($role);
    $employee->stores()->attach($store->id);

    return [$store, $employee, $course];
}

function markAllCoursesCurrent(User $user): void
{
    resolve(UserCourseService::class)->clearAllCaches();

    $courseIds = resolve(UserCourseService::class)->getCourseIds($user->fresh());

    foreach ($courseIds as $courseId) {
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
