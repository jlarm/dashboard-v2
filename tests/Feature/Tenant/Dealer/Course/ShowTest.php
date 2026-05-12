<?php

declare(strict_types=1);

use App\Models\Dealer\Course;
use App\Services\VimeoService;

use function Pest\Laravel\mock;

function makeShowCourse(array $attrs = []): Course
{
    return Course::query()->create(array_merge([
        'name' => 'Show Course',
        'slug' => 'show-course-'.uniqid(),
        'slides' => [],
        'questions' => [],
        'optional' => false,
    ], $attrs));
}

it('renders slides when course has no video', function (): void {
    $course = makeShowCourse([
        'slides' => [
            ['title' => 'Slide One', 'description' => 'First slide content.'],
            ['title' => 'Slide Two', 'description' => 'Second slide content.'],
        ],
    ]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.courses.show', $course))
        ->assertInertia(fn ($page) => $page
            ->component('dealer/courses/Show')
            ->where('video', null)
            ->has('slides', 2));
});

it('renders slides when course has a video_id but vimeo returns null', function (): void {
    $course = makeShowCourse([
        'video_id' => '123456789',
        'slides' => [['title' => 'Fallback Slide', 'description' => 'Fallback content.']],
    ]);

    mock(VimeoService::class)
        ->shouldReceive('getVideo')
        ->andReturn(null);

    $this->actingAs($this->consultant)
        ->get(route('dealer.courses.show', $course))
        ->assertInertia(fn ($page) => $page
            ->component('dealer/courses/Show')
            ->where('video', null)
            ->has('slides', 1));
});

it('renders video when vimeo returns video data', function (): void {
    $course = makeShowCourse(['video_id' => '123456789']);

    mock(VimeoService::class)
        ->shouldReceive('getVideo')
        ->andReturn([
            'player_embed_url' => 'https://player.vimeo.com/video/123456789',
            'title' => 'Test Video',
        ]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.courses.show', $course))
        ->assertInertia(fn ($page) => $page
            ->component('dealer/courses/Show')
            ->where('video.title', 'Test Video')
            ->where('video.player_embed_url', fn ($url) => str_contains((string) $url, 'player.vimeo.com/video/123456789')));
});

it('includes a signed quiz url in props', function (): void {
    $course = makeShowCourse();

    $this->actingAs($this->consultant)
        ->get(route('dealer.courses.show', $course))
        ->assertInertia(fn ($page) => $page->where('quiz_url', fn ($url) => str_contains((string) $url, 'signature=')));
});
