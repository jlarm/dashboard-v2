<?php

declare(strict_types=1);

use App\Models\Dealer\Course;
use App\Services\VimeoService;

it('renders a mobile-friendly vimeo embed url with playback parameters', function (): void {
    $course = Course::query()->create([
        'name' => 'Mobile Vimeo Course',
        'slug' => 'mobile-vimeo-course',
        'slides' => [],
        'questions' => [],
        'optional' => false,
        'years_expires' => 1,
        'video_id' => '1111337198',
    ]);

    $this->mock(VimeoService::class)
        ->shouldReceive('getVideo')
        ->andReturn([
            'id' => '1111337198',
            'title' => 'Mobile Vimeo Course',
            'player_embed_url' => 'https://player.vimeo.com/video/1111337198?h=abc123',
        ]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.courses.show', $course))
        ->assertInertia(fn ($page) => $page
            ->where('video.player_embed_url', function ($url): bool {
                parse_str((string) parse_url((string) $url, PHP_URL_QUERY), $query);

                return ($query['h'] ?? null) === 'abc123'
                    && ($query['playsinline'] ?? null) === '1'
                    && ($query['dnt'] ?? null) === '1'
                    && ($query['progress_bar'] ?? null) === '0';
            }));
});
