<?php

declare(strict_types=1);

use App\Services\VimeoService;
use Mockery\MockInterface;

describe('vimeo:enable-seek', function (): void {
    it('errors out when no video_id is provided and --all is not set', function (): void {
        $this->mock(VimeoService::class, function (MockInterface $mock): void {
            $mock->shouldReceive('getPresetIdByName')->with('Default')->andReturn('preset-123');
            $mock->shouldNotReceive('enableSeekButton');
            $mock->shouldNotReceive('assignPreset');
        });

        tenancy()->end();
        $this->artisan('vimeo:enable-seek')
            ->expectsOutputToContain('Please provide a video ID')
            ->assertExitCode(1);
    });

    it('reports zero work and exits successfully when --all runs against tenants with no course videos', function (): void {
        $this->mock(VimeoService::class, function (MockInterface $mock): void {
            $mock->shouldReceive('getPresetIdByName')->with('Default')->andReturn('preset-123');
            $mock->shouldNotReceive('enableSeekButton');
        });

        tenancy()->end();
        $this->artisan('vimeo:enable-seek', ['--all' => true, '--tenants' => [$this->tenant->id]])
            ->expectsOutputToContain('No course videos found')
            ->assertSuccessful();
    });

    it('calls the Vimeo service for a single explicit video id and returns success when both calls succeed', function (): void {
        $this->mock(VimeoService::class, function (MockInterface $mock): void {
            $mock->shouldReceive('getPresetIdByName')->with('Default')->andReturn('preset-123');
            $mock->shouldReceive('enableSeekButton')->with('999888')->andReturn(true);
            $mock->shouldReceive('assignPreset')->with('999888', 'preset-123')->andReturn(true);
        });

        tenancy()->end();
        $this->artisan('vimeo:enable-seek', ['video_id' => '999888'])
            ->expectsOutputToContain('Seek enabled')
            ->expectsOutputToContain('Default preset assigned')
            ->assertSuccessful();
    });

    it('returns FAILURE when enableSeekButton fails for the provided video id', function (): void {
        $this->mock(VimeoService::class, function (MockInterface $mock): void {
            $mock->shouldReceive('getPresetIdByName')->with('Default')->andReturn(null);
            $mock->shouldReceive('enableSeekButton')->with('555')->andReturn(false);
        });

        tenancy()->end();
        $this->artisan('vimeo:enable-seek', ['video_id' => '555'])
            ->expectsOutputToContain('Could not find a "Default" embed preset')
            ->expectsOutputToContain('Failed to enable seek')
            ->assertExitCode(1);
    });
});

describe('audit:finance-manager-courses', function (): void {
    it('handles tenants that have no Finance Manager users by printing the empty-result branch', function (): void {
        tenancy()->end();
        $this->artisan('audit:finance-manager-courses', ['--tenants' => [$this->tenant->id]])
            ->expectsOutputToContain('Starting Finance Manager course audit')
            ->expectsOutputToContain('No Finance Manager users found')
            ->assertExitCode(0);
    });
});
