<?php

declare(strict_types=1);

use App\Jobs\IssueDotCertificate;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\User;
use Illuminate\Support\Facades\Queue;

beforeEach(function (): void {
    $this->questions = [
        [
            'question' => 'Question 1',
            'correctAnswer' => 'a',
            'answers' => [['a' => 'Right', 'b' => 'Wrong']],
        ],
        [
            'question' => 'Question 2',
            'correctAnswer' => 'b',
            'answers' => [['a' => 'Wrong', 'b' => 'Right']],
        ],
    ];

    $this->user = User::query()->create([
        'name' => 'Quiz Taker',
        'email' => 'quiz-taker@test.com',
        'password' => bcrypt('password'),
    ]);
    $this->user->assignRole('Employee');
});

it('records a passing score when all answers are correct', function (): void {
    Queue::fake();

    $course = Course::query()->create([
        'name' => 'Quiz Course',
        'slug' => 'quiz-course-'.uniqid(),
        'slides' => [],
        'questions' => $this->questions,
        'optional' => false,
    ]);

    $this->actingAs($this->user)
        ->post(route('dealer.courses.results.store', $course), [
            'question' => [1 => 'a', 2 => 'b'],
        ])
        ->assertRedirect(route('dealer.courses.index'));

    $result = CourseResults::query()->where('user_id', $this->user->id)->first();

    expect($result)->not->toBeNull();
    expect((float) $result->percentage)->toBe(100.0);
    expect($result->passed)->toBeTrue();
});

it('marks the attempt as failed when below 70 percent', function (): void {
    Queue::fake();

    $course = Course::query()->create([
        'name' => 'Quiz Course',
        'slug' => 'quiz-course-'.uniqid(),
        'slides' => [],
        'questions' => $this->questions,
        'optional' => false,
    ]);

    $this->actingAs($this->user)
        ->post(route('dealer.courses.results.store', $course), [
            'question' => [1 => 'b', 2 => 'a'],
        ]);

    $result = CourseResults::query()->where('user_id', $this->user->id)->first();

    expect($result->passed)->toBeFalse();
    expect((float) $result->percentage)->toBe(0.0);
});

it('flashes the quiz session payload for the completion modal', function (): void {
    Queue::fake();

    $course = Course::query()->create([
        'name' => 'My Course',
        'slug' => 'my-course-'.uniqid(),
        'slides' => [],
        'questions' => $this->questions,
        'optional' => false,
    ]);

    $this->actingAs($this->user)
        ->post(route('dealer.courses.results.store', $course), [
            'question' => [1 => 'b', 2 => 'a'],
        ])
        ->assertSessionHas('quiz', fn (array $payload): bool => $payload['course_name'] === 'My Course'
                && $payload['passed'] === false
                && count($payload['incorrect_questions']) === 2);
});

it('queues the DOT certificate job when the shipping course passes', function (): void {
    Queue::fake();

    $course = Course::query()
        ->where('slug', 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding')
        ->firstOrFail();
    $course->update(['questions' => $this->questions]);

    $this->actingAs($this->user)
        ->post(route('dealer.courses.results.store', $course), [
            'question' => [1 => 'a', 2 => 'b'],
        ]);

    Queue::assertPushed(IssueDotCertificate::class);
});

it('does not queue the DOT certificate for non-DOT courses', function (): void {
    Queue::fake();

    $course = Course::query()->create([
        'name' => 'Quiz Course',
        'slug' => 'quiz-course-'.uniqid(),
        'slides' => [],
        'questions' => $this->questions,
        'optional' => false,
    ]);

    $this->actingAs($this->user)
        ->post(route('dealer.courses.results.store', $course), [
            'question' => [1 => 'a', 2 => 'b'],
        ]);

    Queue::assertNotPushed(IssueDotCertificate::class);
});

it('does not queue the DOT certificate when the user fails', function (): void {
    Queue::fake();

    $course = Course::query()
        ->where('slug', 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding')
        ->firstOrFail();
    $course->update(['questions' => $this->questions]);

    $this->actingAs($this->user)
        ->post(route('dealer.courses.results.store', $course), [
            'question' => [1 => 'b', 2 => 'a'],
        ]);

    Queue::assertNotPushed(IssueDotCertificate::class);
});
