<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Course\Show;
use App\Models\Dealer\Course;
use App\Services\VimeoService;
use Livewire\Livewire;

use function Pest\Laravel\mock;

it('renders slides when course has no video', function (): void {
    $course = Course::factory()->create([
        'slides' => json_encode([
            ['title' => 'Slide One', 'description' => 'First slide content.'],
            ['title' => 'Slide Two', 'description' => 'Second slide content.'],
        ]),
    ]);

    $this->actingAs($this->consultant);

    Livewire::test(Show::class, ['course' => $course])
        ->assertStatus(200)
        ->assertSee('Slide One');
});

it('renders slides when course has a video_id but vimeo returns null', function (): void {
    $course = Course::factory()->create([
        'video_id' => '123456789',
        'slides' => json_encode([
            ['title' => 'Fallback Slide', 'description' => 'Fallback content.'],
        ]),
    ]);

    mock(VimeoService::class)
        ->shouldReceive('getVideo')
        ->andReturn(null);

    $this->actingAs($this->consultant);

    Livewire::test(Show::class, ['course' => $course])
        ->assertStatus(200)
        ->assertSee('Fallback Slide');
});

it('renders video when vimeo returns video data', function (): void {
    $course = Course::factory()->create([
        'video_id' => '123456789',
        'slides' => json_encode([]),
    ]);

    mock(VimeoService::class)
        ->shouldReceive('getVideo')
        ->andReturn([
            'player_embed_url' => 'https://player.vimeo.com/video/123456789',
            'title' => 'Test Video',
        ]);

    $this->actingAs($this->consultant);

    Livewire::test(Show::class, ['course' => $course])
        ->assertStatus(200);
});
