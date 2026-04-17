<?php

declare(strict_types=1);

use App\Models\Dealer\Course;
use App\Models\Dealer\Department;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\UserCourseService;
use Spatie\Permission\Models\Role;

beforeEach(function (): void {
    resolve(UserCourseService::class)->clearAllCaches();
});

describe('Course Assignment - Role Based', function (): void {
    it('assigns courses to users based on their role', function (): void {
        $role = Role::query()->where('name', 'Manager')->first();
        $course = Course::query()->create([
            'name' => 'Manager Training Course',
            'slug' => 'manager-training',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($role->id);

        $user = User::query()->create([
            'name' => 'Test Manager',
            'email' => 'test-manager@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Manager');

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($course->id);
    });

    it('assigns courses to employees based on their role', function (): void {
        $role = Role::query()->where('name', 'Employee')->first();
        $course = Course::query()->create([
            'name' => 'Employee Safety Course',
            'slug' => 'employee-safety',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($role->id);

        $user = User::query()->create([
            'name' => 'Test Employee',
            'email' => 'test-employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($course->id);
    });

    it('does not assign courses to consultants automatically', function (): void {
        // Consultants and other admin roles should never be assigned courses automatically
        $consultantRole = Role::query()->where('name', 'Consultant')->first();
        $course = Course::query()->create([
            'name' => 'Test Course',
            'slug' => 'test-course-consultant',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($consultantRole->id);

        $user = User::query()->create([
            'name' => 'Consultant User',
            'email' => 'consultant-test@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Consultant');

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        // FIXED: Consultants now properly return empty array
        expect($courseIds)->toBeEmpty();
    });

    it('allows consultants to have manually added courses', function (): void {
        // Admin users can still have courses manually assigned via course_user
        $course = Course::query()->create([
            'name' => 'Custom Admin Course',
            'slug' => 'custom-admin-course',
            'slides' => [],
            'optional' => false,
        ]);

        $user = User::query()->create([
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

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($course->id);
    });

    it('does not assign optional courses automatically', function (): void {
        $role = Role::query()->where('name', 'Employee')->first();
        $course = Course::query()->create([
            'name' => 'Optional Training',
            'slug' => 'optional-training-test',
            'slides' => [],
            'optional' => true,
        ]);
        $course->roles()->attach($role->id);

        $user = User::query()->create([
            'name' => 'Test Employee',
            'email' => 'test-employee-optional@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        // FIXED: Optional courses are now properly excluded
        expect($courseIds)->not->toContain($course->id);
    });
});

describe('Course Assignment - Department Based', function (): void {
    it('assigns courses to users based on their department', function (): void {
        $department = Department::query()->create(['name' => 'Sales Dept Test', 'slug' => 'sales-dept-test']);
        $role = Role::query()->where('name', 'Employee')->first();

        $course = Course::query()->create([
            'name' => 'Sales Training',
            'slug' => 'sales-training-dept',
            'slides' => [],
            'optional' => false,
        ]);
        $course->departments()->attach($department->id);
        $course->roles()->attach($role->id);

        $user = User::query()->create([
            'name' => 'Sales Employee',
            'email' => 'sales-employee@test.com',
            'password' => bcrypt('password'),
            'department_id' => $department->id,
        ]);
        $user->assignRole('Employee');

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($course->id);
    });

    it('does not assign department-specific courses to users in different departments', function (): void {
        $salesDept = Department::query()->create(['name' => 'Sales Dept 2', 'slug' => 'sales-dept-2']);
        $serviceDept = Department::query()->create(['name' => 'Service Dept 2', 'slug' => 'service-dept-2']);
        $role = Role::query()->where('name', 'Employee')->first();

        $course = Course::query()->create([
            'name' => 'Sales Training 2',
            'slug' => 'sales-training-2',
            'slides' => [],
            'optional' => false,
        ]);
        $course->departments()->attach($salesDept->id);
        $course->roles()->attach($role->id);

        $user = User::query()->create([
            'name' => 'Service Employee',
            'email' => 'service-employee@test.com',
            'password' => bcrypt('password'),
            'department_id' => $serviceDept->id,
        ]);
        $user->assignRole('Employee');

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->not->toContain($course->id);
    });

    it('assigns courses without departments to all users with matching roles', function (): void {
        $role = Role::query()->where('name', 'Manager')->first();

        $course = Course::query()->create([
            'name' => 'General Management',
            'slug' => 'general-management-test',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($role->id);

        $user = User::query()->create([
            'name' => 'Manager Without Dept',
            'email' => 'manager-nodept@test.com',
            'password' => bcrypt('password'),
            'department_id' => null,
        ]);
        $user->assignRole('Manager');

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($course->id);
    });
});

describe('Course Assignment - Custom Overrides', function (): void {
    it('includes manually added courses via course_user pivot', function (): void {
        $user = User::query()->create([
            'name' => 'Test User',
            'email' => 'test-override-1@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $course = Course::query()->create([
            'name' => 'Custom Course',
            'slug' => 'custom-course-override',
            'slides' => [],
            'optional' => false,
        ]);

        $user->courses()->attach($course->id, [
            'type' => 'add',
            'assigned_by' => $this->consultant->id,
        ]);

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($course->id);
    });

    it('excludes courses marked as excluded via course_user pivot', function (): void {
        $role = Role::query()->where('name', 'Employee')->first();
        $course = Course::query()->create([
            'name' => 'Required Course',
            'slug' => 'required-course-to-exclude',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($role->id);

        $user = User::query()->create([
            'name' => 'Test User',
            'email' => 'test-exclude@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        // Course should be assigned by default
        $service = resolve(UserCourseService::class);
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

    it('can add and exclude different courses for the same user', function (): void {
        $role = Role::query()->where('name', 'Employee')->first();

        $requiredCourse = Course::query()->create([
            'name' => 'Required Course',
            'slug' => 'required-course-multi',
            'slides' => [],
            'optional' => false,
        ]);
        $requiredCourse->roles()->attach($role->id);

        $customCourse = Course::query()->create([
            'name' => 'Custom Added Course',
            'slug' => 'custom-course-multi',
            'slides' => [],
            'optional' => false,
        ]);

        $user = User::query()->create([
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

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->not->toContain($requiredCourse->id)
            ->and($courseIds)->toContain($customCourse->id);
    });
});

describe('Course Assignment - Special Cases', function (): void {
    it('includes sexual-harassment-m course for managers', function (): void {
        // Managers should get the sexual-harassment-m course
        $managerRole = Role::query()->where('name', 'Manager')->first();

        $course = Course::query()->create([
            'name' => 'Sexual Harassment for Managers',
            'slug' => 'sexual-harassment-m',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($managerRole->id);

        $user = User::query()->create([
            'name' => 'Manager User',
            'email' => 'manager-sh@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Manager');

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        // Managers should get sexual-harassment-m
        expect($courseIds)->toContain($course->id);
    });

    it('includes sexual-harassment-e course for employees', function (): void {
        // Employees should get the sexual-harassment-e course
        $employeeRole = Role::query()->where('name', 'Employee')->first();

        $course = Course::query()->create([
            'name' => 'Sexual Harassment for Employees',
            'slug' => 'sexual-harassment-e',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($employeeRole->id);

        $user = User::query()->create([
            'name' => 'Employee User',
            'email' => 'employee-sh@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        // Employees should get sexual-harassment-e
        expect($courseIds)->toContain($course->id);
    });

    it('excludes state-specific course for users not in that state', function (): void {
        $role = Role::query()->where('name', 'Employee')->first();

        $caCourse = Course::query()->create([
            'name' => 'California Sexual Harassment Training',
            'slug' => 'sexual-harassment-training-in-california',
            'slides' => [],
            'optional' => false,
            'states_required' => ['California'],
        ]);
        $caCourse->roles()->attach($role->id);

        $store = Store::query()->create([
            'name' => 'Texas Store Test',
            'slug' => 'texas-store-test-sc',
            'state' => 'Texas',
        ]);

        $user = User::query()->create([
            'name' => 'Employee User',
            'email' => 'employee-ca-no@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');
        $user->stores()->attach($store->id);

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->not->toContain($caCourse->id);
    });

    it('includes state-specific course for users in that state', function (): void {
        $role = Role::query()->where('name', 'Employee')->first();

        $caCourse = Course::query()->create([
            'name' => 'California Sexual Harassment Training',
            'slug' => 'sexual-harassment-training-in-california-2',
            'slides' => [],
            'optional' => false,
            'states_required' => ['California'],
        ]);
        $caCourse->roles()->attach($role->id);

        $store = Store::query()->create([
            'name' => 'California Store Test',
            'slug' => 'california-store-test-sc',
            'state' => 'California',
        ]);

        $user = User::query()->create([
            'name' => 'Employee User',
            'email' => 'employee-ca-yes@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');
        $user->stores()->attach($store->id);

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($caCourse->id);
    });
});

describe('Course Assignment - State Based', function (): void {
    it('replaces general course with state-specific course for users in that state', function (): void {
        $role = Role::query()->where('name', 'Employee')->first();

        $generalCourse = Course::query()->create([
            'name' => 'General Harassment',
            'slug' => 'general-harassment-state-test',
            'slides' => [],
            'optional' => false,
        ]);
        $generalCourse->roles()->attach($role->id);

        $stateCourse = Course::query()->create([
            'name' => 'CA Harassment',
            'slug' => 'ca-harassment-state-test',
            'slides' => [],
            'optional' => false,
            'states_required' => ['California'],
            'replaces_course_slugs' => ['general-harassment-state-test'],
        ]);

        $store = Store::query()->create([
            'name' => 'CA Store State Test',
            'slug' => 'ca-store-state-test',
            'state' => 'California',
        ]);

        $user = User::query()->create([
            'name' => 'CA Employee',
            'email' => 'ca-employee-state@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');
        $user->stores()->attach($store->id);

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($stateCourse->id)
            ->and($courseIds)->not->toContain($generalCourse->id);
    });

    it('keeps general course for users not in the state with a replacement', function (): void {
        $role = Role::query()->where('name', 'Employee')->first();

        $generalCourse = Course::query()->create([
            'name' => 'General Harassment TX',
            'slug' => 'general-harassment-tx-test',
            'slides' => [],
            'optional' => false,
        ]);
        $generalCourse->roles()->attach($role->id);

        Course::query()->create([
            'name' => 'CA Harassment TX',
            'slug' => 'ca-harassment-tx-test',
            'slides' => [],
            'optional' => false,
            'states_required' => ['California'],
            'replaces_course_slugs' => ['general-harassment-tx-test'],
        ]);

        $store = Store::query()->create([
            'name' => 'TX Store',
            'slug' => 'tx-store-state-test',
            'state' => 'Texas',
        ]);

        $user = User::query()->create([
            'name' => 'TX Employee',
            'email' => 'tx-employee-state@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');
        $user->stores()->attach($store->id);

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($generalCourse->id);
    });

    it('handles users with stores in multiple states', function (): void {
        $role = Role::query()->where('name', 'Employee')->first();

        $generalCourse = Course::query()->create([
            'name' => 'General Harassment Multi',
            'slug' => 'general-harassment-multi-test',
            'slides' => [],
            'optional' => false,
        ]);
        $generalCourse->roles()->attach($role->id);

        $caCourse = Course::query()->create([
            'name' => 'CA Harassment Multi',
            'slug' => 'ca-harassment-multi-test',
            'slides' => [],
            'optional' => false,
            'states_required' => ['California'],
            'replaces_course_slugs' => ['general-harassment-multi-test'],
        ]);

        $caStore = Store::query()->create([
            'name' => 'CA Store Multi',
            'slug' => 'ca-store-multi-test',
            'state' => 'California',
        ]);

        $txStore = Store::query()->create([
            'name' => 'TX Store Multi',
            'slug' => 'tx-store-multi-test',
            'state' => 'Texas',
        ]);

        $user = User::query()->create([
            'name' => 'Multi-State Employee',
            'email' => 'multi-state-employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');
        $user->stores()->attach([$caStore->id, $txStore->id]);

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        // CA state course applies, general is replaced
        expect($courseIds)->toContain($caCourse->id)
            ->and($courseIds)->not->toContain($generalCourse->id);
    });

    it('uses primary store state instead of all assigned stores when primary store is set', function (): void {
        $role = Role::query()->where('name', 'Employee')->first();

        $generalCourse = Course::query()->create([
            'name' => 'General Harassment Primary',
            'slug' => 'general-harassment-primary-test',
            'slides' => [],
            'optional' => false,
        ]);
        $generalCourse->roles()->attach($role->id);

        $caCourse = Course::query()->create([
            'name' => 'CA Harassment Primary',
            'slug' => 'ca-harassment-primary-test',
            'slides' => [],
            'optional' => false,
            'states_required' => ['California'],
            'replaces_course_slugs' => ['general-harassment-primary-test'],
        ]);

        $caStore = Store::query()->create([
            'name' => 'CA Primary Store',
            'slug' => 'ca-primary-store-test',
            'state' => 'California',
        ]);

        $txStore = Store::query()->create([
            'name' => 'TX Primary Store',
            'slug' => 'tx-primary-store-test',
            'state' => 'Texas',
        ]);

        // User is assigned both stores but primary store is TX — CA courses should not apply
        $user = User::query()->create([
            'name' => 'Primary Store Employee',
            'email' => 'primary-store-employee@test.com',
            'password' => bcrypt('password'),
            'primary_store_id' => $txStore->id,
        ]);
        $user->assignRole('Employee');
        $user->stores()->attach([$caStore->id, $txStore->id]);

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        // TX primary store means CA course does not apply; general course should be included
        expect($courseIds)->not->toContain($caCourse->id)
            ->and($courseIds)->toContain($generalCourse->id);
    });

    it('falls back to all assigned stores states when no primary store is set', function (): void {
        $role = Role::query()->where('name', 'Employee')->first();

        $generalCourse = Course::query()->create([
            'name' => 'General Harassment Fallback',
            'slug' => 'general-harassment-fallback-test',
            'slides' => [],
            'optional' => false,
        ]);
        $generalCourse->roles()->attach($role->id);

        $caCourse = Course::query()->create([
            'name' => 'CA Harassment Fallback',
            'slug' => 'ca-harassment-fallback-test',
            'slides' => [],
            'optional' => false,
            'states_required' => ['California'],
            'replaces_course_slugs' => ['general-harassment-fallback-test'],
        ]);

        $caStore = Store::query()->create([
            'name' => 'CA Fallback Store',
            'slug' => 'ca-fallback-store-test',
            'state' => 'California',
        ]);

        $txStore = Store::query()->create([
            'name' => 'TX Fallback Store',
            'slug' => 'tx-fallback-store-test',
            'state' => 'Texas',
        ]);

        // No primary store — CA course applies because CA store is assigned
        $user = User::query()->create([
            'name' => 'Fallback Employee',
            'email' => 'fallback-employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');
        $user->stores()->attach([$caStore->id, $txStore->id]);

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($caCourse->id)
            ->and($courseIds)->not->toContain($generalCourse->id);
    });
});

describe('Course Assignment - Edge Cases', function (): void {
    it('returns empty array for users with no roles', function (): void {
        $user = User::query()->create([
            'name' => 'No Role User',
            'email' => 'norole@test.com',
            'password' => bcrypt('password'),
        ]);

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toBeEmpty();
    });

    it('combines courses from multiple roles', function (): void {
        $managerRole = Role::query()->where('name', 'Manager')->first();
        $employeeRole = Role::query()->where('name', 'Employee')->first();

        $managerCourse = Course::query()->create([
            'name' => 'Manager Course',
            'slug' => 'manager-course-multi',
            'slides' => [],
            'optional' => false,
        ]);
        $managerCourse->roles()->attach($managerRole->id);

        $employeeCourse = Course::query()->create([
            'name' => 'Employee Course',
            'slug' => 'employee-course-multi',
            'slides' => [],
            'optional' => false,
        ]);
        $employeeCourse->roles()->attach($employeeRole->id);

        $user = User::query()->create([
            'name' => 'Multi Role User',
            'email' => 'multirole@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole(['Manager', 'Employee']);

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect($courseIds)->toContain($managerCourse->id)
            ->and($courseIds)->toContain($employeeCourse->id);
    });

    it('does not duplicate course ids in result', function (): void {
        $role = Role::query()->where('name', 'Employee')->first();

        $course = Course::query()->create([
            'name' => 'Test Course',
            'slug' => 'test-course-dupl',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($role->id);

        $user = User::query()->create([
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

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($user);

        expect(array_count_values($courseIds)[$course->id] ?? 0)->toBe(1);
    });
});

describe('Course Assignment - Service Methods', function (): void {
    it('getCoursesSimple returns correct courses based on assignment rules', function (): void {
        $employeeRole = Role::query()->where('name', 'Employee')->first();

        // Course 1: Assigned to Employee role, no department (assigned to ALL employees)
        $employeeCourse = Course::query()->create([
            'name' => 'Employee Course',
            'slug' => 'employee-course-simple',
            'slides' => [],
            'optional' => false,
        ]);
        $employeeCourse->roles()->attach($employeeRole->id);

        // Course 2: No department, no role (assigned to EVERYONE)
        $universalCourse = Course::query()->create([
            'name' => 'Universal Course',
            'slug' => 'universal-course-simple',
            'slides' => [],
            'optional' => false,
        ]);

        $user = User::query()->create([
            'name' => 'Test User',
            'email' => 'test-simple@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $service = resolve(UserCourseService::class);
        $courses = $service->getCoursesSimple($user);

        // Both courses should be assigned
        expect($courses->pluck('id')->toArray())->toContain($employeeCourse->id)
            ->and($courses->pluck('id')->toArray())->toContain($universalCourse->id);
    });

    it('getCoursesWithResults includes results relationship', function (): void {
        $role = Role::query()->where('name', 'Employee')->first();
        $course = Course::query()->create([
            'name' => 'Test Course With Results',
            'slug' => 'test-course-results',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($role->id);

        $user = User::query()->create([
            'name' => 'Test User',
            'email' => 'test-results@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        $service = resolve(UserCourseService::class);
        $courses = $service->getCoursesWithResults($user);

        $assignedCourse = $courses->firstWhere('id', $course->id);
        expect($assignedCourse)->not->toBeNull()
            ->and($assignedCourse->relationLoaded('results'))->toBeTrue();
    });
});
