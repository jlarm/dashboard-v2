<?php

declare(strict_types=1);

use App\Models\Course;
use Database\Seeders\RoleAndPermissionSeeder;

beforeEach(function (): void {
    $this->seed(RoleAndPermissionSeeder::class);
});

it('updates a course name, video id, and slides for super-admin', function (): void {
    $course = Course::query()->create([
        'name' => 'Before',
        'slug' => 'slides-course-'.uniqid(),
        'slides' => [],
        'questions' => [],
    ]);

    asSuperAdmin()
        ->patch(route('course-management.update', $course), [
            'name' => 'After',
            'video_id' => 'vid-123',
            'slides' => [
                ['title' => 'Intro', 'description' => 'Hello world'],
            ],
        ])
        ->assertRedirect()
        ->assertSessionHas('flash.success', 'Course updated.');

    $course->refresh();

    expect($course->name)->toBe('After')
        ->and($course->video_id)->toBe('vid-123')
        ->and($course->slides)->toHaveCount(1)
        ->and($course->slides[0]['title'])->toBe('Intro');
});

it('requires at least one slide', function (): void {
    $course = Course::query()->create([
        'name' => 'Needs Slide',
        'slug' => 'needs-slide-'.uniqid(),
        'slides' => [['title' => 'Old', 'description' => 'Old']],
        'questions' => [],
    ]);

    asSuperAdmin()
        ->from(route('course-management.edit', $course))
        ->patch(route('course-management.update', $course), [
            'name' => 'Still here',
            'slides' => [],
        ])
        ->assertSessionHasErrors('slides');
});

it('forbids non super-admin users from updating slides', function (): void {
    $course = Course::query()->create([
        'name' => 'Guarded',
        'slug' => 'guarded-course-'.uniqid(),
        'slides' => [],
        'questions' => [],
    ]);

    asConsultant()
        ->patch(route('course-management.update', $course), [
            'name' => 'Hacked',
            'slides' => [['title' => 'Bad', 'description' => 'Bad']],
        ])
        ->assertForbidden();

    expect($course->fresh()->name)->toBe('Guarded');
});
