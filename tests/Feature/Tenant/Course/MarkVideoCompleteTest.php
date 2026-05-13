<?php

declare(strict_types=1);

use App\Models\Dealer\Course;
use App\Models\User;
use App\Models\VideoProgress;

function makeCourse(?string $videoId = null): Course
{
    return Course::query()->create([
        'name' => 'Video Course',
        'slug' => 'video-course-'.uniqid(),
        'slides' => [],
        'questions' => [],
        'optional' => false,
        'video_id' => $videoId,
    ]);
}

it('records video progress when authenticated', function (): void {
    $user = User::query()->create([
        'name' => 'Watcher',
        'email' => 'watcher@test.com',
        'password' => bcrypt('password'),
    ]);
    $user->assignRole('Employee');

    $course = makeCourse('987654321');

    $this->actingAs($user)
        ->post(route('dealer.courses.video-complete', $course))
        ->assertRedirect();

    expect(VideoProgress::query()
        ->where('user_id', $user->id)
        ->where('video_id', '987654321')
        ->where('completed', true)
        ->exists()
    )->toBeTrue();
});

it('is a no-op for courses without a video', function (): void {
    $user = User::query()->create([
        'name' => 'Watcher',
        'email' => 'watcher-noop@test.com',
        'password' => bcrypt('password'),
    ]);
    $user->assignRole('Employee');

    $course = makeCourse();

    $this->actingAs($user)
        ->post(route('dealer.courses.video-complete', $course));

    expect(VideoProgress::query()->where('user_id', $user->id)->exists())->toBeFalse();
});

it('rejects unauthenticated requests', function (): void {
    $course = makeCourse('111');

    $this->post(route('dealer.courses.video-complete', $course))
        ->assertRedirect(route('dealer.login'));
});
