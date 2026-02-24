<?php

declare(strict_types=1);

use App\Http\Livewire\Central\CourseManagement\EditQuiz;
use App\Models\Course;
use Database\Seeders\RoleAndPermissionSeeder;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->seed(RoleAndPermissionSeeder::class);
});

describe('central course management edit quiz', function (): void {
    it('dispatches a success notification browser event when updating quiz', function (): void {
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

        Livewire::test(EditQuiz::class, ['course' => $course])
            ->set('questions', [
                [
                    'question' => 'Updated question',
                    'answers' => [['A' => 'Answer A'], ['B' => 'Answer B']],
                    'correctAnswer' => 'Answer B',
                ],
            ])
            ->call('update')
            ->assertDispatchedBrowserEvent('course-quiz-updated', [
                'status' => 'success',
                'message' => 'Course quiz updated.',
            ]);

        $course->refresh();

        expect($course->questions[0]['question'])->toBe('Updated question');
    });
});
