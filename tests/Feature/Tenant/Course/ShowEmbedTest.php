<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Course\Show;
use App\Models\Dealer\Course;
use App\Services\VimeoService;
use Livewire\Livewire;

it('renders a mobile-friendly vimeo embed url and iframe permissions', function (): void {
    $course = Course::query()->create([
        'name' => 'Mobile Vimeo Course',
        'slug' => 'mobile-vimeo-course',
        'slides' => [],
        'questions' => [],
        'optional' => false,
        'years_expires' => 1,
        'video_id' => '1111337198',
    ]);

    $mock = $this->mock(VimeoService::class);
    $mock->shouldReceive('getVideo')->once()->andReturn([
        'id' => '1111337198',
        'title' => 'Mobile Vimeo Course',
        'player_embed_url' => 'https://player.vimeo.com/video/1111337198?h=abc123',
    ]);

    $this->actingAs($this->consultant);

    $component = Livewire::test(Show::class, ['course' => $course]);
    $embedUrl = $component->instance()->playerEmbedUrl();

    expect($embedUrl)->not->toBeNull();

    parse_str((string) parse_url((string) $embedUrl, PHP_URL_QUERY), $query);

    expect($query['h'] ?? null)->toBe('abc123')
        ->and($query['playsinline'] ?? null)->toBe('1')
        ->and($query['dnt'] ?? null)->toBe('1')
        ->and($query['progress_bar'] ?? null)->toBe('0');

    $component->assertSeeHtml('allow="autoplay; fullscreen; picture-in-picture; encrypted-media"')
        ->assertSeeHtml('allowfullscreen')
        ->assertSeeHtml('webkitallowfullscreen');
});
