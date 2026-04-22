<?php

declare(strict_types=1);

use App\Models\Course;
use App\Models\Department;
use Database\Seeders\RoleAndPermissionSeeder;
use Spatie\Permission\Models\Role;

beforeEach(function (): void {
    $this->seed(RoleAndPermissionSeeder::class);
});

describe('central course management settings', function (): void {
    it('syncs departments, roles, states, and replaces on the central course', function (): void {
        $course = Course::query()->create([
            'name' => 'Settings Course',
            'slug' => 'settings-course-'.uniqid(),
            'slides' => [],
            'questions' => [],
        ]);

        $otherCourse = Course::query()->create([
            'name' => 'Base Course',
            'slug' => 'base-course-'.uniqid(),
            'slides' => [],
            'questions' => [],
        ]);

        $department = Department::query()->firstOrCreate(
            ['name' => 'Sales'],
            ['slug' => 'sales'],
        );
        $role = Role::query()->where('name', 'Employee')->firstOrFail();

        asSuperAdmin();

        $response = $this->patch(route('course-management.update-settings', $course), [
            'department_ids' => [$department->id],
            'role_ids' => [$role->id],
            'states_required' => ['California'],
            'replaces_course_slugs' => [$otherCourse->slug],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('flash.success', 'Course settings updated.');

        $course->refresh();

        expect($course->states_required)->toBe(['California'])
            ->and($course->replaces_course_slugs)->toBe([$otherCourse->slug])
            ->and($course->departments()->pluck('departments.id')->all())->toBe([$department->id])
            ->and($course->roles()->pluck('roles.id')->all())->toBe([$role->id]);
    });

    it('clears states and replaces when submitted empty', function (): void {
        $course = Course::query()->create([
            'name' => 'Clearing Course',
            'slug' => 'clearing-course-'.uniqid(),
            'slides' => [],
            'questions' => [],
            'states_required' => ['California'],
            'replaces_course_slugs' => ['some-slug'],
        ]);

        asSuperAdmin();

        $this->patch(route('course-management.update-settings', $course), [
            'department_ids' => [],
            'role_ids' => [],
            'states_required' => [],
            'replaces_course_slugs' => [],
        ])->assertRedirect();

        $course->refresh();

        expect($course->states_required)->toBeNull()
            ->and($course->replaces_course_slugs)->toBeNull();
    });

    it('forbids non super-admin users', function (): void {
        $course = Course::query()->create([
            'name' => 'Forbidden Course',
            'slug' => 'forbidden-course-'.uniqid(),
            'slides' => [],
            'questions' => [],
        ]);

        asConsultant();

        $this->patch(route('course-management.update-settings', $course), [
            'department_ids' => [],
            'role_ids' => [],
            'states_required' => [],
            'replaces_course_slugs' => [],
        ])->assertForbidden();
    });
});
