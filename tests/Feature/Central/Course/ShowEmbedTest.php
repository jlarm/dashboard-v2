<?php

declare(strict_types=1);

use App\Http\Livewire\Central\Course\Show;
use App\Models\Course;
use App\Models\User;
use App\Services\VimeoService;
use Livewire\Livewire;

it('renders a mobile-friendly vimeo embed url and iframe permissions for central courses', function (): void {
    $course = Course::query()->create([
        'name' => 'Central Mobile Vimeo Course',
        'slug' => 'central-mobile-vimeo-course',
        'slides' => [],
        'questions' => [],
        'video_id' => '1111337198',
    ]);

    $mock = $this->mock(VimeoService::class);
    $mock->shouldReceive('getVideo')->once()->andReturn([
        'id' => '1111337198',
        'title' => 'Central Mobile Vimeo Course',
        'player_embed_url' => 'https://player.vimeo.com/video/1111337198?h=xyz789',
    ]);

    $user = User::factory()->create();
    $this->actingAs($user);

    $component = Livewire::test(Show::class, ['course' => $course]);
    $embedUrl = $component->instance()->playerEmbedUrl();

    expect($embedUrl)->not->toBeNull();

    parse_str((string) parse_url((string) $embedUrl, PHP_URL_QUERY), $query);

    expect($query['h'] ?? null)->toBe('xyz789')
        ->and($query['playsinline'] ?? null)->toBe('1')
        ->and($query['dnt'] ?? null)->toBe('1')
        ->and($query['progress_bar'] ?? null)->toBe('0');

    $component->assertSeeHtml('allow="autoplay; fullscreen; picture-in-picture; encrypted-media"')
        ->assertSeeHtml('allowfullscreen')
        ->assertSeeHtml('webkitallowfullscreen');
});
