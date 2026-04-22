<?php

declare(strict_types=1);

use App\Models\Course;
use Database\Seeders\RoleAndPermissionSeeder;

beforeEach(function (): void {
    $this->seed(RoleAndPermissionSeeder::class);
});

describe('central course management edit page', function (): void {
    it('renders the edit page with slides and quiz data', function (): void {
        $course = Course::query()->create([
            'name' => 'Edit Page Course',
            'slug' => 'edit-page-course-'.uniqid(),
            'slides' => [['title' => 'Slide 1', 'description' => '<p>Hi</p>']],
            'questions' => [['question' => 'Q?', 'answers' => [['a' => 'A']], 'correctAnswer' => 'A']],
        ]);

        asSuperAdmin();

        $this->get(route('course-management.edit', $course))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('central/course-management/Edit')
                ->where('course.slug', $course->slug)
                ->has('course.slides', 1)
                ->has('course.questions', 1)
            );
    });
});

describe('central course management update quiz', function (): void {
    it('updates course quiz and redirects with success flash', function (): void {
        $course = Course::query()->create([
            'name' => 'Quiz Course',
            'slug' => 'quiz-course-'.uniqid(),
            'questions' => [
                [
                    'question' => 'Old question',
                    'answers' => [['A' => 'Answer A']],
                    'correctAnswer' => 'Answer A',
                ],
            ],
            'slides' => [],
        ]);

        asSuperAdmin();

        $response = $this->patch(route('course-management.update-quiz', $course), [
            'questions' => [
                [
                    'question' => 'Updated question',
                    'answers' => [['key' => 'A', 'value' => 'Answer A'], ['key' => 'B', 'value' => 'Answer B']],
                    'correctAnswer' => 'Answer B',
                ],
            ],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('flash.success', 'Course quiz updated.');

        $course->refresh();

        expect($course->questions[0]['question'])->toBe('Updated question')
            ->and($course->questions[0]['correctAnswer'])->toBe('Answer B');
    });

    it('forbids non super-admin users', function (): void {
        $course = Course::query()->create([
            'name' => 'Quiz Course',
            'slug' => 'quiz-course-'.uniqid(),
            'questions' => [],
            'slides' => [],
        ]);

        asConsultant();

        $this->patch(route('course-management.update-quiz', $course), [
            'questions' => [],
        ])->assertForbidden();
    });
});
