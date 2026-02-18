<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealer\Course as DealerCourse;
use App\Services\VimeoService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class EnableVimeoSeek extends Command
{
    protected $signature = 'vimeo:enable-seek {video_id? : A specific Vimeo video ID} {--all : Enable seek on all course videos} {--tenants=* : Specific tenant(s) to scan. Defaults to all.}';
    protected $description = 'Enable the seek/scrub button on Vimeo videos via the API';

    public function handle(VimeoService $vimeoService): int
    {
        if ($this->option('all')) {
            return $this->enableForAllCourses($vimeoService);
        }

        $videoId = $this->argument('video_id');

        if (! $videoId) {
            $this->error('Please provide a video ID or use --all to enable seek on all course videos.');

            return self::FAILURE;
        }

        return $this->enableSeek($vimeoService, (string) $videoId) ? self::SUCCESS : self::FAILURE;
    }

    private function enableForAllCourses(VimeoService $vimeoService): int
    {
        $videoIds = new Collection();

        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) use ($videoIds): void {
            $tenantVideoIds = DealerCourse::query()->whereNotNull('video_id')->pluck('video_id');
            $this->line("Tenant {$tenant->id}: found {$tenantVideoIds->count()} video(s)");
            $videoIds->push(...$tenantVideoIds);
        });

        $uniqueVideoIds = $videoIds->unique()->values();

        if ($uniqueVideoIds->isEmpty()) {
            $this->warn('No course videos found across any tenant.');

            return self::SUCCESS;
        }

        $this->newLine();
        $this->info("Enabling seek on {$uniqueVideoIds->count()} unique video(s)...");
        $this->newLine();

        $passed = 0;
        $failed = 0;

        foreach ($uniqueVideoIds as $videoId) {
            if ($this->enableSeek($vimeoService, (string) $videoId)) {
                $passed++;
            } else {
                $failed++;
            }
        }

        $this->newLine();
        $this->table(['Result', 'Count'], [
            ['Success', $passed],
            ['Failed', $failed],
        ]);

        return $failed === 0 ? self::SUCCESS : self::FAILURE;
    }

    private function enableSeek(VimeoService $vimeoService, string $videoId): bool
    {
        $this->line("Enabling seek for video ID: {$videoId}");

        $success = $vimeoService->enableSeekButton($videoId);

        if ($success) {
            $this->info("  ✓ Seek enabled for video {$videoId}");
        } else {
            $this->error("  ✗ Failed to enable seek for video {$videoId}");
        }

        return $success;
    }
}
