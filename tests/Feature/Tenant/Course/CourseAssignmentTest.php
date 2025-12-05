<?php

declare(strict_types=1);

use App\Models\Dealer\Course;
use App\Models\Dealer\Department;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\UserCourseService;
use Spatie\Permission\Models\Role;

describe('Course Assignment - Role Based', function () {
    it('assigns courses to users based on their role', function () {
        $role = Role::where('name', 'Manager')->first();
        $course = Course::create([
            'name' => 'Manager Training Course',
            'slug' => 'manager-training',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($role->id);

        $user = User::create([
            'name' => 'Test Manager',
            'email' => 'test-manager@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Manager');

        $service = app(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($course->id);
    });

    it('assigns courses to employees based on their role', function () {
        $role = Role::where('name', 'Employee')->first();
        $course = Course::create([
            'name' => 'Employee Safety Course',
            'slug' => 'employee-safety',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($role->id);

        $user = User::create([
            'name' => 'Test Employee',
            'email' => 'test-employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $service = app(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($course->id);
    });

    it('does not assign courses to consultants automatically', function () {
        // Consultants and other admin roles should never be assigned courses automatically
        $consultantRole = Role::where('name', 'Consultant')->first();
        $course = Course::create([
            'name' => 'Test Course',
            'slug' => 'test-course-consultant',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($consultantRole->id);

        $user = User::create([
            'name' => 'Consultant User',
            'email' => 'consultant-test@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Consultant');

        $service = app(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        // FIXED: Consultants now properly return empty array
        expect($courseIds)->toBeEmpty();
    });

    it('allows consultants to have manually added courses', function () {
        // Admin users can still have courses manually assigned via course_user
        $course = Course::create([
            'name' => 'Custom Admin Course',
            'slug' => 'custom-admin-course',
            'slides' => [],
            'optional' => false,
        ]);

        $user = User::create([
            'name' => 'Consultant User',
            'email' => 'consultant-manual@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Consultant');

        // Manually add the course
        $user->courses()->attach($course->id, [
            'type' => 'add',
            'assigned_by' => $this->consultant->id,
        ]);

        $service = app(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($course->id);
    });

    it('does not assign optional courses automatically', function () {
        $role = Role::where('name', 'Employee')->first();
        $course = Course::create([
            'name' => 'Optional Training',
            'slug' => 'optional-training-test',
            'slides' => [],
            'optional' => true,
        ]);
        $course->roles()->attach($role->id);

        $user = User::create([
            'name' => 'Test Employee',
            'email' => 'test-employee-optional@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $service = app(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        // FIXED: Optional courses are now properly excluded
        expect($courseIds)->not->toContain($course->id);
    });
});

describe('Course Assignment - Department Based', function () {
    it('assigns courses to users based on their department', function () {
        $department = Department::create(['name' => 'Sales Dept Test', 'slug' => 'sales-dept-test']);
        $role = Role::where('name', 'Employee')->first();

        $course = Course::create([
            'name' => 'Sales Training',
            'slug' => 'sales-training-dept',
            'slides' => [],
            'optional' => false,
        ]);
        $course->departments()->attach($department->id);
        $course->roles()->attach($role->id);

        $user = User::create([
            'name' => 'Sales Employee',
            'email' => 'sales-employee@test.com',
            'password' => bcrypt('password'),
            'department_id' => $department->id,
        ]);
        $user->assignRole('Employee');

        $service = app(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($course->id);
    });

    it('does not assign department-specific courses to users in different departments', function () {
        $salesDept = Department::create(['name' => 'Sales Dept 2', 'slug' => 'sales-dept-2']);
        $serviceDept = Department::create(['name' => 'Service Dept 2', 'slug' => 'service-dept-2']);
        $role = Role::where('name', 'Employee')->first();

        $course = Course::create([
            'name' => 'Sales Training 2',
            'slug' => 'sales-training-2',
            'slides' => [],
            'optional' => false,
        ]);
        $course->departments()->attach($salesDept->id);
        $course->roles()->attach($role->id);

        $user = User::create([
            'name' => 'Service Employee',
            'email' => 'service-employee@test.com',
            'password' => bcrypt('password'),
            'department_id' => $serviceDept->id,
        ]);
        $user->assignRole('Employee');

        $service = app(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->not->toContain($course->id);
    });

    it('assigns courses without departments to all users with matching roles', function () {
        $role = Role::where('name', 'Manager')->first();

        $course = Course::create([
            'name' => 'General Management',
            'slug' => 'general-management-test',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($role->id);

        $user = User::create([
            'name' => 'Manager Without Dept',
            'email' => 'manager-nodept@test.com',
            'password' => bcrypt('password'),
            'department_id' => null,
        ]);
        $user->assignRole('Manager');

        $service = app(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($course->id);
    });
});

describe('Course Assignment - Custom Overrides', function () {
    it('includes manually added courses via course_user pivot', function () {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test-override-1@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $course = Course::create([
            'name' => 'Custom Course',
            'slug' => 'custom-course-override',
            'slides' => [],
            'optional' => false,
        ]);

        $user->courses()->attach($course->id, [
            'type' => 'add',
            'assigned_by' => $this->consultant->id,
        ]);

        $service = app(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($course->id);
    });

    it('excludes courses marked as excluded via course_user pivot', function () {
        $role = Role::where('name', 'Employee')->first();
        $course = Course::create([
            'name' => 'Required Course',
            'slug' => 'required-course-to-exclude',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($role->id);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'test-exclude@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        // Course should be assigned by default
        $service = app(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);
        expect($courseIds)->toContain($course->id);

        // Now exclude it
        $user->courses()->attach($course->id, [
            'type' => 'exclude',
            'assigned_by' => $this->consultant->id,
        ]);
        $user->clearCourseCache();

        $courseIds = $service->getCourseIds($user);
        expect($courseIds)->not->toContain($course->id);
    });

    it('can add and exclude different courses for the same user', function () {
        $role = Role::where('name', 'Employee')->first();

        $requiredCourse = Course::create([
            'name' => 'Required Course',
            'slug' => 'required-course-multi',
            'slides' => [],
            'optional' => false,
        ]);
        $requiredCourse->roles()->attach($role->id);

        $customCourse = Course::create([
            'name' => 'Custom Added Course',
            'slug' => 'custom-course-multi',
            'slides' => [],
            'optional' => false,
        ]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'test-multi@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        // Exclude the required course
        $user->courses()->attach($requiredCourse->id, [
            'type' => 'exclude',
            'assigned_by' => $this->consultant->id,
        ]);

        // Add a custom course
        $user->courses()->attach($customCourse->id, [
            'type' => 'add',
            'assigned_by' => $this->consultant->id,
        ]);

        $service = app(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->not->toContain($requiredCourse->id)
            ->and($courseIds)->toContain($customCourse->id);
    });
});

describe('Course Assignment - Special Cases', function () {
    it('includes sexual-harassment-m course for managers', function () {
        // Managers should get the sexual-harassment-m course
        $managerRole = Role::where('name', 'Manager')->first();

        $course = Course::create([
            'name' => 'Sexual Harassment for Managers',
            'slug' => 'sexual-harassment-m',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($managerRole->id);

        $user = User::create([
            'name' => 'Manager User',
            'email' => 'manager-sh@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Manager');

        $service = app(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        // Managers should get sexual-harassment-m
        expect($courseIds)->toContain($course->id);
    });

    it('includes sexual-harassment-e course for employees', function () {
        // Employees should get the sexual-harassment-e course
        $employeeRole = Role::where('name', 'Employee')->first();

        $course = Course::create([
            'name' => 'Sexual Harassment for Employees',
            'slug' => 'sexual-harassment-e',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($employeeRole->id);

        $user = User::create([
            'name' => 'Employee User',
            'email' => 'employee-sh@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $service = app(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        // Employees should get sexual-harassment-e
        expect($courseIds)->toContain($course->id);
    });

    it('excludes california sexual harassment course for users without california stores', function () {
        $role = Role::where('name', 'Employee')->first();

        $course = Course::create([
            'name' => 'California Sexual Harassment Training',
            'slug' => 'sexual-harassment-training-in-california',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($role->id);

        $store = Store::create([
            'name' => 'Texas Store Test',
            'slug' => 'texas-store-test',
            'state' => 'Texas',
        ]);

        $user = User::create([
            'name' => 'Employee User',
            'email' => 'employee-ca-no@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');
        $user->stores()->attach($store->id);

        $service = app(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->not->toContain($course->id);
    });

    it('includes california sexual harassment course for users with california stores', function () {
        $role = Role::where('name', 'Employee')->first();

        $course = Course::create([
            'name' => 'California Sexual Harassment Training',
            'slug' => 'sexual-harassment-training-in-california-2',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($role->id);

        $store = Store::create([
            'name' => 'California Store Test',
            'slug' => 'california-store-test',
            'state' => 'California',
        ]);

        $user = User::create([
            'name' => 'Employee User',
            'email' => 'employee-ca-yes@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');
        $user->stores()->attach($store->id);

        $service = app(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($course->id);
    });
});

describe('Course Assignment - Edge Cases', function () {
    it('returns empty array for users with no roles', function () {
        $user = User::create([
            'name' => 'No Role User',
            'email' => 'norole@test.com',
            'password' => bcrypt('password'),
        ]);

        $service = app(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toBeEmpty();
    });

    it('combines courses from multiple roles', function () {
        $managerRole = Role::where('name', 'Manager')->first();
        $employeeRole = Role::where('name', 'Employee')->first();

        $managerCourse = Course::create([
            'name' => 'Manager Course',
            'slug' => 'manager-course-multi',
            'slides' => [],
            'optional' => false,
        ]);
        $managerCourse->roles()->attach($managerRole->id);

        $employeeCourse = Course::create([
            'name' => 'Employee Course',
            'slug' => 'employee-course-multi',
            'slides' => [],
            'optional' => false,
        ]);
        $employeeCourse->roles()->attach($employeeRole->id);

        $user = User::create([
            'name' => 'Multi Role User',
            'email' => 'multirole@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole(['Manager', 'Employee']);

        $service = app(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($managerCourse->id)
            ->and($courseIds)->toContain($employeeCourse->id);
    });

    it('does not duplicate course ids in result', function () {
        $role = Role::where('name', 'Employee')->first();

        $course = Course::create([
            'name' => 'Test Course',
            'slug' => 'test-course-dupl',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($role->id);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'test-dedup@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        // Also add the same course manually
        $user->courses()->attach($course->id, [
            'type' => 'add',
            'assigned_by' => $this->consultant->id,
        ]);

        $service = app(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect(array_count_values($courseIds)[$course->id] ?? 0)->toBe(1);
    });
});

describe('Course Assignment - Service Methods', function () {
    it('getCoursesSimple returns correct courses based on assignment rules', function () {
        $employeeRole = Role::where('name', 'Employee')->first();

        // Course 1: Assigned to Employee role, no department (assigned to ALL employees)
        $employeeCourse = Course::create([
            'name' => 'Employee Course',
            'slug' => 'employee-course-simple',
            'slides' => [],
            'optional' => false,
        ]);
        $employeeCourse->roles()->attach($employeeRole->id);

        // Course 2: No department, no role (assigned to EVERYONE)
        $universalCourse = Course::create([
            'name' => 'Universal Course',
            'slug' => 'universal-course-simple',
            'slides' => [],
            'optional' => false,
        ]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'test-simple@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $service = app(UserCourseService::class);
        $courses = $service->getCoursesSimple($user);

        // Both courses should be assigned
        expect($courses->pluck('id')->toArray())->toContain($employeeCourse->id)
            ->and($courses->pluck('id')->toArray())->toContain($universalCourse->id);
    });

    it('getCoursesWithResults includes results relationship', function () {
        $role = Role::where('name', 'Employee')->first();
        $course = Course::create([
            'name' => 'Test Course With Results',
            'slug' => 'test-course-results',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($role->id);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'test-results@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $service = app(UserCourseService::class);
        $courses = $service->getCoursesWithResults($user);

        $assignedCourse = $courses->firstWhere('id', $course->id);
        expect($assignedCourse)->not->toBeNull()
            ->and($assignedCourse->relationLoaded('results'))->toBeTrue();
    });
});
