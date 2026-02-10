<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Employee\CourseResults;
use App\Models\Dealer\Course;
use App\Models\Dealer\Department;
use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

describe('CourseResults Component - Course Display', function (): void {
    it('displays only assigned courses for sales employee', function (): void {
        $salesDept = Department::query()->create(['name' => 'Sales Team', 'slug' => 'sales-team']);
        $employeeRole = Role::query()->where('name', 'Employee')->first();

        // Create courses
        $universalCourse = Course::query()->create([
            'name' => 'Universal Safety',
            'slug' => 'universal-safety',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $salesCourse = Course::query()->create([
            'name' => 'Sales Training',
            'slug' => 'sales-training',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);
        $salesCourse->departments()->attach($salesDept->id);
        $salesCourse->roles()->attach($employeeRole->id);

        $serviceCourse = Course::query()->create([
            'name' => 'Service Training',
            'slug' => 'service-training',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);
        $serviceDept = Department::query()->create(['name' => 'Service Team', 'slug' => 'service-team']);
        $serviceCourse->departments()->attach($serviceDept->id);
        $serviceCourse->roles()->attach($employeeRole->id);

        $user = User::query()->create([
            'name' => 'Sales Employee',
            'email' => 'sales@test.com',
            'password' => bcrypt('password'),
            'department_id' => $salesDept->id,
        ]);
        $user->assignRole('Employee');

        Livewire::test(CourseResults::class, ['user' => $user])
            ->assertViewHas('courses', function ($courses) use ($universalCourse, $salesCourse, $serviceCourse): bool {
                $courseIds = $courses->pluck('id')->toArray();

                return in_array($universalCourse->id, $courseIds) &&
                       in_array($salesCourse->id, $courseIds) &&
                       ! in_array($serviceCourse->id, $courseIds);
            });
    });

    it('displays sexual harassment employee course for employees', function (): void {
        $employeeRole = Role::query()->where('name', 'Employee')->first();

        $course = Course::query()->create([
            'name' => 'Sexual Harassment Employee',
            'slug' => 'sexual-harassment-e',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($employeeRole->id);

        $user = User::query()->create([
            'name' => 'Employee',
            'email' => 'emp@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        Livewire::test(CourseResults::class, ['user' => $user])
            ->assertViewHas('courses', fn ($courses) => $courses->pluck('id')->contains($course->id));
    });

    it('displays sexual harassment manager course for managers', function (): void {
        $managerRole = Role::query()->where('name', 'Manager')->first();

        $course = Course::query()->create([
            'name' => 'Sexual Harassment Manager',
            'slug' => 'sexual-harassment-m',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($managerRole->id);

        $user = User::query()->create([
            'name' => 'Manager',
            'email' => 'mgr@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Manager');

        Livewire::test(CourseResults::class, ['user' => $user])
            ->assertViewHas('courses', fn ($courses) => $courses->pluck('id')->contains($course->id));
    });

    it('excludes california course for users without california stores', function (): void {
        $employeeRole = Role::query()->where('name', 'Employee')->first();

        $course = Course::query()->create([
            'name' => 'CA Sexual Harassment',
            'slug' => 'sexual-harassment-training-in-california',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($employeeRole->id);

        $store = Store::query()->create([
            'name' => 'Texas Store',
            'slug' => 'texas-store',
            'state' => 'Texas',
        ]);

        $user = User::query()->create([
            'name' => 'Employee',
            'email' => 'emp-tx@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');
        $user->stores()->attach($store->id);

        Livewire::test(CourseResults::class, ['user' => $user])
            ->assertViewHas('courses', fn ($courses): bool => ! $courses->pluck('id')->contains($course->id));
    });

    it('includes california course for users with california stores', function (): void {
        $employeeRole = Role::query()->where('name', 'Employee')->first();

        $course = Course::query()->create([
            'name' => 'CA Sexual Harassment',
            'slug' => 'sexual-harassment-training-in-california-2',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($employeeRole->id);

        $store = Store::query()->create([
            'name' => 'California Store',
            'slug' => 'california-store',
            'state' => 'California',
        ]);

        $user = User::query()->create([
            'name' => 'Employee',
            'email' => 'emp-ca@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');
        $user->stores()->attach($store->id);

        Livewire::test(CourseResults::class, ['user' => $user])
            ->assertViewHas('courses', fn ($courses) => $courses->pluck('id')->contains($course->id));
    });

    it('does not display optional courses', function (): void {
        $employeeRole = Role::query()->where('name', 'Employee')->first();

        $optionalCourse = Course::query()->create([
            'name' => 'Optional Training',
            'slug' => 'optional-training-results',
            'slides' => [],
            'questions' => [],
            'optional' => true,
        ]);
        $optionalCourse->roles()->attach($employeeRole->id);

        $user = User::query()->create([
            'name' => 'Employee',
            'email' => 'emp-opt@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        Livewire::test(CourseResults::class, ['user' => $user])
            ->assertViewHas('courses', fn ($courses): bool => ! $courses->pluck('id')->contains($optionalCourse->id));
    });

    it('displays manually added courses for consultants', function (): void {
        $course = Course::query()->create([
            'name' => 'Custom Course',
            'slug' => 'custom-course-results',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $user = User::query()->create([
            'name' => 'Consultant',
            'email' => 'consultant@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Consultant');

        // Manually add course
        $user->courses()->attach($course->id, [
            'type' => 'add',
            'assigned_by' => $this->consultant->id,
        ]);

        Livewire::test(CourseResults::class, ['user' => $user])
            ->assertViewHas('courses', fn ($courses) => $courses->pluck('id')->contains($course->id));
    });
});

describe('CourseResults Component - Refresh', function (): void {
    it('refreshes user data when refreshEmployeeDetails event is emitted', function (): void {
        $user = User::query()->create([
            'name' => 'Test User',
            'email' => 'refresh@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $component = Livewire::test(CourseResults::class, ['user' => $user]);

        // Emit refresh event
        $component->call('refreshDetails');

        // Component should not error and should refresh
        $component->assertHasNoErrors();
    });
});
