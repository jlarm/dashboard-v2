<?php

declare(strict_types=1);

use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function (): void {
    $this->employeeRole = Role::query()->where('name', 'Employee')->first();

    $this->user = User::query()->create([
        'name' => 'DOT Test User',
        'email' => 'dot-prop-shape@test.com',
        'password' => bcrypt('password'),
    ]);
    $this->user->assignRole('Employee');

    $this->module1 = Course::query()->create([
        'name' => 'DOT Module 1',
        'slug' => 'dot-hazardous-materials-transportation',
        'slides' => [],
        'questions' => [['question' => 'q', 'correctAnswer' => 'a', 'answers' => [['a' => 'A']]]],
        'optional' => false,
    ]);
    $this->module1->roles()->attach($this->employeeRole->id);

    $this->module2 = Course::query()->create([
        'name' => 'DOT Module 2',
        'slug' => 'dot-hazardous-materials-transportation-identifying-hazardous-materials',
        'slides' => [],
        'questions' => [['question' => 'q', 'correctAnswer' => 'a', 'answers' => [['a' => 'A']]]],
        'optional' => false,
    ]);
    $this->module2->roles()->attach($this->employeeRole->id);
});

describe('Course Index page - row props', function (): void {
    it('marks module 2 as locked until module 1 is passed', function (): void {
        $this->actingAs($this->user)
            ->get(route('dealer.courses.index'))
            ->assertInertia(fn ($page) => $page
                ->where('courses', function ($courses): bool {
                    $bySlug = collect($courses)->keyBy('slug');

                    return $bySlug['dot-hazardous-materials-transportation']['is_locked'] === false
                        && $bySlug['dot-hazardous-materials-transportation-identifying-hazardous-materials']['is_locked'] === true;
                }));
    });

    it('unlocks module 2 once module 1 is passed', function (): void {
        CourseResults::query()->create([
            'user_id' => $this->user->id,
            'course_id' => $this->module1->id,
            'passed' => true,
            'percentage' => 90,
        ]);

        $this->actingAs($this->user)
            ->get(route('dealer.courses.index'))
            ->assertInertia(fn ($page) => $page
                ->where('courses', function ($courses): bool {
                    $bySlug = collect($courses)->keyBy('slug');

                    return $bySlug['dot-hazardous-materials-transportation-identifying-hazardous-materials']['is_locked'] === false;
                }));
    });

    it('keeps module 2 locked when module 1 was failed', function (): void {
        CourseResults::query()->create([
            'user_id' => $this->user->id,
            'course_id' => $this->module1->id,
            'passed' => false,
            'percentage' => 30,
        ]);

        $this->actingAs($this->user)
            ->get(route('dealer.courses.index'))
            ->assertInertia(fn ($page) => $page
                ->where('courses', fn ($c): bool => collect($c)->keyBy('slug')->get('dot-hazardous-materials-transportation-identifying-hazardous-materials')['is_locked'] === true));
    });

    it('uses years_expires when computing expiration (not the hardcoded 365 days)', function (): void {
        // A 2-year course passed 18 months ago should still be "passed", not "expired".
        $longCourse = Course::query()->create([
            'name' => 'Long-cycle Training',
            'slug' => 'long-cycle-training',
            'slides' => [],
            'questions' => [['question' => 'q', 'correctAnswer' => 'a', 'answers' => [['a' => 'A']]]],
            'optional' => false,
            'years_expires' => 2,
        ]);
        $longCourse->roles()->attach($this->employeeRole->id);

        CourseResults::query()->create([
            'user_id' => $this->user->id,
            'course_id' => $longCourse->id,
            'passed' => true,
            'percentage' => 95,
            'created_at' => now()->subMonths(18),
            'updated_at' => now()->subMonths(18),
        ]);

        $this->actingAs($this->user)
            ->get(route('dealer.courses.index'))
            ->assertInertia(fn ($page) => $page
                ->where('courses', fn ($c): bool => collect($c)->keyBy('slug')->get('long-cycle-training')['status'] === 'passed'));
    });

    it('marks course as expired once years_expires has elapsed', function (): void {
        $longCourse = Course::query()->create([
            'name' => 'Long-cycle Training',
            'slug' => 'long-cycle-training-expired',
            'slides' => [],
            'questions' => [['question' => 'q', 'correctAnswer' => 'a', 'answers' => [['a' => 'A']]]],
            'optional' => false,
            'years_expires' => 1,
        ]);
        $longCourse->roles()->attach($this->employeeRole->id);

        CourseResults::query()->create([
            'user_id' => $this->user->id,
            'course_id' => $longCourse->id,
            'passed' => true,
            'percentage' => 95,
            'created_at' => now()->subYears(2),
            'updated_at' => now()->subYears(2),
        ]);

        $this->actingAs($this->user)
            ->get(route('dealer.courses.index'))
            ->assertInertia(fn ($page) => $page
                ->where('courses', fn ($c): bool => collect($c)->keyBy('slug')->get('long-cycle-training-expired')['status'] === 'expired'));
    });
});
