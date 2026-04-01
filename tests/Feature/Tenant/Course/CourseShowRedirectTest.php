<?php

declare(strict_types=1);

use App\Models\Dealer\Course;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\UserCourseService;
use Spatie\Permission\Models\Role;

beforeEach(function (): void {
    app(UserCourseService::class)->clearAllCaches();
});

it('redirects illinois employee from sexual-harassment-e to sexual-harassment-illinois', function (): void {
    $employeeRole = Role::query()->where('name', 'Employee')->firstOrFail();

    $employeeCourse = Course::query()->create([
        'name' => 'Sexual Harassment E',
        'slug' => 'sexual-harassment-e',
        'slides' => [],
        'questions' => [['question' => 'q']],
        'optional' => false,
    ]);
    $employeeCourse->roles()->attach($employeeRole->id);

    $illinoisEmployeeCourse = Course::query()->create([
        'name' => 'Illinois Sexual Harassment E',
        'slug' => 'sexual-harassment-illinois',
        'slides' => [],
        'questions' => [['question' => 'q']],
        'optional' => false,
        'states_required' => ['Illinois'],
        'replaces_course_slugs' => ['sexual-harassment-e'],
    ]);
    $illinoisEmployeeCourse->roles()->attach($employeeRole->id);

    $illinoisStore = Store::query()->create([
        'name' => 'Illinois Store Redirect',
        'slug' => 'illinois-store-redirect',
        'state' => 'Illinois',
    ]);

    $user = User::query()->create([
        'name' => 'Illinois Employee Redirect',
        'email' => 'illinois-employee-redirect@test.com',
        'password' => bcrypt('password'),
    ]);
    $user->assignRole('Employee');
    $user->stores()->attach($illinoisStore->id);

    $this->actingAs($user);

    $response = $this->get(route('dealer.courses.show', $employeeCourse));

    $response->assertRedirect(route('dealer.courses.show', $illinoisEmployeeCourse));
});

it('redirects illinois manager from sexual-harassment-m to sexual-harassment-illinois-m', function (): void {
    $managerRole = Role::query()->where('name', 'Manager')->firstOrFail();

    $managerCourse = Course::query()->create([
        'name' => 'Sexual Harassment M',
        'slug' => 'sexual-harassment-m',
        'slides' => [],
        'questions' => [['question' => 'q']],
        'optional' => false,
    ]);
    $managerCourse->roles()->attach($managerRole->id);

    $illinoisManagerCourse = Course::query()->create([
        'name' => 'Illinois Sexual Harassment M',
        'slug' => 'sexual-harassment-illinois-m',
        'slides' => [],
        'questions' => [['question' => 'q']],
        'optional' => false,
        'states_required' => ['Illinois'],
        'replaces_course_slugs' => ['sexual-harassment-m'],
    ]);
    $illinoisManagerCourse->roles()->attach($managerRole->id);

    $illinoisStore = Store::query()->create([
        'name' => 'Illinois Store Manager Redirect',
        'slug' => 'illinois-store-manager-redirect',
        'state' => 'IL',
    ]);

    $user = User::query()->create([
        'name' => 'Illinois Manager Redirect',
        'email' => 'illinois-manager-redirect@test.com',
        'password' => bcrypt('password'),
    ]);
    $user->assignRole('Manager');
    $user->stores()->attach($illinoisStore->id);

    $this->actingAs($user);

    $response = $this->get(route('dealer.courses.show', $managerCourse));

    $response->assertRedirect(route('dealer.courses.show', $illinoisManagerCourse));
});

it('redirects illinois employee from sexual-harassment-e even when illinois course has no role attachment', function (): void {
    $employeeRole = Role::query()->where('name', 'Employee')->firstOrFail();

    $employeeCourse = Course::query()->create([
        'name' => 'Sexual Harassment E',
        'slug' => 'sexual-harassment-e',
        'slides' => [],
        'questions' => [['question' => 'q']],
        'optional' => false,
    ]);
    $employeeCourse->roles()->attach($employeeRole->id);

    $illinoisEmployeeCourse = Course::query()->create([
        'name' => 'Illinois Sexual Harassment E',
        'slug' => 'sexual-harassment-illinois',
        'slides' => [],
        'questions' => [['question' => 'q']],
        'optional' => false,
        'states_required' => ['Illinois'],
        'replaces_course_slugs' => ['sexual-harassment-e'],
    ]);

    $illinoisStore = Store::query()->create([
        'name' => 'Illinois Store No Role Redirect',
        'slug' => 'illinois-store-no-role-redirect',
        'state' => 'Illinois',
    ]);

    $user = User::query()->create([
        'name' => 'Illinois Employee No Role Redirect',
        'email' => 'illinois-employee-no-role-redirect@test.com',
        'password' => bcrypt('password'),
    ]);
    $user->assignRole('Employee');
    $user->stores()->attach($illinoisStore->id);

    $this->actingAs($user);

    $response = $this->get(route('dealer.courses.show', $employeeCourse));

    $response->assertRedirect(route('dealer.courses.show', $illinoisEmployeeCourse));
});

it('redirects to state replacement course for non-illinois states when replaces matches clicked slug', function (): void {
    $employeeRole = Role::query()->where('name', 'Employee')->firstOrFail();

    $generalCourse = Course::query()->create([
        'name' => 'General Harassment Replacement Test',
        'slug' => 'general-harassment-replace-test',
        'slides' => [],
        'questions' => [['question' => 'q']],
        'optional' => false,
    ]);
    $generalCourse->roles()->attach($employeeRole->id);

    $californiaCourse = Course::query()->create([
        'name' => 'California Harassment Replacement Test',
        'slug' => 'ca-harassment-replace-test',
        'slides' => [],
        'questions' => [['question' => 'q']],
        'optional' => false,
        'states_required' => ['California'],
        'replaces_course_slugs' => ['general-harassment-replace-test'],
    ]);
    $californiaCourse->roles()->attach($employeeRole->id);

    $californiaStore = Store::query()->create([
        'name' => 'California Redirect Store',
        'slug' => 'california-redirect-store',
        'state' => 'California',
    ]);

    $user = User::query()->create([
        'name' => 'California Redirect Employee',
        'email' => 'california-redirect-employee@test.com',
        'password' => bcrypt('password'),
    ]);
    $user->assignRole('Employee');
    $user->stores()->attach($californiaStore->id);

    $this->actingAs($user);

    $response = $this->get(route('dealer.courses.show', $generalCourse));

    $response->assertRedirect(route('dealer.courses.show', $californiaCourse));
});
