<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Course\Index;
use App\Models\Dealer\Course;
use App\Models\Dealer\Department;
use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

describe('Course Index Component - Course Display', function (): void {
    it('displays only assigned courses for sales employee', function (): void {
        $salesDept = Department::query()->create(['name' => 'Sales Dept', 'slug' => 'sales-dept']);
        $employeeRole = Role::query()->where('name', 'Employee')->first();

        // Create universal course
        $universalCourse = Course::query()->create([
            'name' => 'Universal Safety Training',
            'slug' => 'universal-safety-training',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        // Create sales-specific course
        $salesCourse = Course::query()->create([
            'name' => 'Sales Techniques',
            'slug' => 'sales-techniques',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);
        $salesCourse->departments()->attach($salesDept->id);
        $salesCourse->roles()->attach($employeeRole->id);

        // Create service-specific course
        $serviceDept = Department::query()->create(['name' => 'Service Dept', 'slug' => 'service-dept']);
        $serviceCourse = Course::query()->create([
            'name' => 'Service Protocol',
            'slug' => 'service-protocol',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);
        $serviceCourse->departments()->attach($serviceDept->id);
        $serviceCourse->roles()->attach($employeeRole->id);

        $user = User::query()->create([
            'name' => 'Sales Employee',
            'email' => 'sales-emp-index@test.com',
            'password' => bcrypt('password'),
            'department_id' => $salesDept->id,
        ]);
        $user->assignRole('Employee');

        $this->actingAs($user);

        Livewire::test(Index::class)
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
            'name' => 'Sexual Harassment Employee Training',
            'slug' => 'sexual-harassment-e',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($employeeRole->id);

        $user = User::query()->create([
            'name' => 'Employee User',
            'email' => 'emp-sh-index@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->assertViewHas('courses', fn ($courses) => $courses->pluck('id')->contains($course->id));
    });

    it('displays sexual harassment manager course for managers', function (): void {
        $managerRole = Role::query()->where('name', 'Manager')->first();

        $course = Course::query()->create([
            'name' => 'Sexual Harassment Manager Training',
            'slug' => 'sexual-harassment-m',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($managerRole->id);

        $user = User::query()->create([
            'name' => 'Manager User',
            'email' => 'mgr-sh-index@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Manager');

        $this->actingAs($user);

        Livewire::test(Index::class)
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
            'name' => 'Texas Location',
            'slug' => 'texas-location',
            'state' => 'Texas',
        ]);

        $user = User::query()->create([
            'name' => 'Texas Employee',
            'email' => 'emp-tx-index@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');
        $user->stores()->attach($store->id);

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->assertViewHas('courses', fn ($courses): bool => ! $courses->pluck('id')->contains($course->id));
    });

    it('includes california course for users with california stores', function (): void {
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
            'name' => 'California Location',
            'slug' => 'california-location',
            'state' => 'California',
        ]);

        $user = User::query()->create([
            'name' => 'California Employee',
            'email' => 'emp-ca-index@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');
        $user->stores()->attach($store->id);

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->assertViewHas('courses', fn ($courses) => $courses->pluck('id')->contains($course->id));
    });

    it('does not display optional courses', function (): void {
        $employeeRole = Role::query()->where('name', 'Employee')->first();

        $optionalCourse = Course::query()->create([
            'name' => 'Optional Training Module',
            'slug' => 'optional-training-module',
            'slides' => [],
            'questions' => [],
            'optional' => true,
        ]);
        $optionalCourse->roles()->attach($employeeRole->id);

        $user = User::query()->create([
            'name' => 'Employee User',
            'email' => 'emp-opt-index@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->assertViewHas('courses', fn ($courses): bool => ! $courses->pluck('id')->contains($optionalCourse->id));
    });

    it('displays manually added courses for consultants', function (): void {
        $course = Course::query()->create([
            'name' => 'Custom Consultant Course',
            'slug' => 'custom-consultant-course',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $admin = User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin-index@test.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('Admin');

        $user = User::query()->create([
            'name' => 'Consultant User',
            'email' => 'consultant-index@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Consultant');

        // Manually add course
        $user->courses()->attach($course->id, [
            'type' => 'add',
            'assigned_by' => $admin->id,
        ]);

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->assertViewHas('courses', fn ($courses) => $courses->pluck('id')->contains($course->id));
    });

    it('does not display courses for admin roles without manual assignment', function (): void {
        $employeeRole = Role::query()->where('name', 'Employee')->first();

        $course = Course::query()->create([
            'name' => 'Regular Employee Course',
            'slug' => 'regular-employee-course',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($employeeRole->id);

        $user = User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin-no-courses@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Admin');

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->assertViewHas('courses', fn ($courses): bool => ! $courses->pluck('id')->contains($course->id));
    });
});
