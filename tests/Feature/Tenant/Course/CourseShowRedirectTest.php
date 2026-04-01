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

it('redirects illinois manager from sexual-harassment-e to sexual-harassment-illinois-m', function (): void {
    $managerRole = Role::query()->where('name', 'Manager')->firstOrFail();

    $employeeCourse = Course::query()->create([
        'name' => 'Sexual Harassment E',
        'slug' => 'sexual-harassment-e',
        'slides' => [],
        'questions' => [['question' => 'q']],
        'optional' => false,
    ]);

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

    $response = $this->get(route('dealer.courses.show', $employeeCourse));

    $response->assertRedirect(route('dealer.courses.show', $illinoisManagerCourse));
});
