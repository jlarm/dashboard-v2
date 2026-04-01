<?php

declare(strict_types=1);

use App\Http\Livewire\Central\CourseManagement\Import;
use App\Models\Course;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->seed(RoleAndPermissionSeeder::class);
});

describe('central course management import', function (): void {
    it('allows importing a course with empty slides', function (): void {
        asSuperAdmin();

        $json = json_encode([
            [
                'name' => 'Imported Empty Slides Course',
                'slug' => 'imported-empty-slides-course',
                'department' => [],
                'roles' => [],
                'slides' => [],
                'questions' => [],
            ],
        ], JSON_THROW_ON_ERROR);

        Livewire::test(Import::class)
            ->set('courseImportFile', UploadedFile::fake()->createWithContent('course-empty-slides.json', $json))
            ->call('importCourses')
            ->assertHasNoErrors();

        $course = Course::query()->where('slug', 'imported-empty-slides-course')->firstOrFail();

        expect($course->slides)->toBe([]);
    });

    it('imports a course from json with state replacement fields', function (): void {
        asSuperAdmin();

        $json = json_encode([
            [
                'name' => 'Imported California Course',
                'slug' => 'imported-california-course',
                'department' => [],
                'roles' => [],
                'states_required' => ['California'],
                'replaces_course_slugs' => ['sexual-harassment-e', 'sexual-harassment-m'],
                'slides' => [
                    [
                        'title' => 'Slide 1',
                        'description' => 'Course content',
                    ],
                ],
                'questions' => [],
            ],
        ], JSON_THROW_ON_ERROR);

        $component = Livewire::test(Import::class)
            ->set('courseImportFile', UploadedFile::fake()->createWithContent('course-import.json', $json))
            ->call('importCourses');

        $component->assertHasNoErrors();

        $course = Course::query()->where('slug', 'imported-california-course')->firstOrFail();

        expect($course->states_required)->toBe(['California'])
            ->and($course->replaces_course_slugs)->toBe(['sexual-harassment-e', 'sexual-harassment-m']);
    });

    it('updates an existing course when the imported slug already exists', function (): void {
        asSuperAdmin();

        Course::query()->create([
            'name' => 'Original Course',
            'slug' => 'existing-import-course',
            'slides' => [
                [
                    'title' => 'Old Slide',
                    'description' => 'Old Content',
                ],
            ],
            'questions' => [],
        ]);

        $json = json_encode([
            [
                'name' => 'Updated Import Course',
                'slug' => 'existing-import-course',
                'department' => [],
                'roles' => [],
                'states_required' => ['California'],
                'replaces_course_slugs' => ['general-harassment'],
                'slides' => [
                    [
                        'title' => 'Updated Slide',
                        'description' => 'Updated content',
                    ],
                ],
                'questions' => [],
            ],
        ], JSON_THROW_ON_ERROR);

        $component = Livewire::test(Import::class)
            ->set('courseImportFile', UploadedFile::fake()->createWithContent('course-update.json', $json))
            ->call('importCourses');

        $component->assertHasNoErrors();

        $course = Course::query()->where('slug', 'existing-import-course')->firstOrFail();

        expect($course->name)->toBe('Updated Import Course')
            ->and($course->slides[0]['title'])->toBe('Updated Slide')
            ->and($course->states_required)->toBe(['California'])
            ->and($course->replaces_course_slugs)->toBe(['general-harassment']);
    });
});
