<?php

declare(strict_types=1);

use App\Models\Course;
use App\Models\CourseResults;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('model_has_roles')->truncate();
    DB::table('users')->truncate();
    DB::table('course_results')->truncate();
    DB::table('courses')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

describe('quiz page', function (): void {
    it('renders the quiz component with questions for allowed users', function (): void {
        $course = Course::factory()->create([
            'questions' => [['question' => 'What?', 'answers' => [['A' => 'Yes']], 'correctAnswer' => 'A']],
        ]);

        asSuperAdmin()
            ->get(route('courses.quiz', $course))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('central/course/Quiz')
                ->has('questions', 1)
            );
    });

    it('forbids users without a central role from the quiz page', function (): void {
        $course = Course::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('courses.quiz', $course))
            ->assertForbidden();
    });
});

describe('quiz submission', function (): void {
    it('stores a course result and redirects to the index', function (): void {
        $course = Course::factory()->create([
            'questions' => [
                ['question' => 'Q1', 'answers' => [['A' => 'a'], ['B' => 'b']], 'correctAnswer' => 'A'],
                ['question' => 'Q2', 'answers' => [['A' => 'a'], ['B' => 'b']], 'correctAnswer' => 'B'],
            ],
        ]);

        asSuperAdmin()
            ->post(route('courses.quiz.store', $course), [
                'question' => ['A', 'B'],
            ])
            ->assertRedirect(route('courses.index'));

        $result = CourseResults::query()->sole();

        expect($result->course_id)->toBe($course->id)
            ->and($result->percentage)->toBe(100)
            ->and($result->passed)->toBeTrue();
    });

    it('records a failing percentage when answers are wrong', function (): void {
        $course = Course::factory()->create([
            'questions' => [
                ['question' => 'Q1', 'answers' => [['A' => 'a'], ['B' => 'b']], 'correctAnswer' => 'A'],
                ['question' => 'Q2', 'answers' => [['A' => 'a'], ['B' => 'b']], 'correctAnswer' => 'B'],
            ],
        ]);

        asSuperAdmin()
            ->post(route('courses.quiz.store', $course), [
                'question' => ['B', 'A'],
            ])
            ->assertRedirect(route('courses.index'));

        $result = CourseResults::query()->sole();

        expect($result->percentage)->toBe(0)
            ->and($result->passed)->toBeFalse();
    });

    it('validates that question is an array of strings', function (): void {
        $course = Course::factory()->create();

        asSuperAdmin()
            ->from(route('courses.show', $course))
            ->post(route('courses.quiz.store', $course), [])
            ->assertSessionHasErrors('question');
    });

    it('forbids users without a central role from submitting results', function (): void {
        $course = Course::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('courses.quiz.store', $course), ['question' => ['A']])
            ->assertForbidden();

        expect(CourseResults::query()->count())->toBe(0);
    });
});
