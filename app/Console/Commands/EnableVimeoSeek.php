<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealer\Course as DealerCourse;
use App\Services\VimeoService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Override;

class EnableVimeoSeek extends Command
{
    #[Override]
    protected $signature = 'vimeo:enable-seek {video_id? : A specific Vimeo video ID} {--all : Enable seek on all course videos} {--tenants=* : Specific tenant(s) to scan. Defaults to all.}';

    #[Override]
    protected $description = 'Enable the seek/scrub button and assign the Default embed preset on Vimeo videos';

    public function handle(VimeoService $vimeoService): int
    {
        $presetId = $vimeoService->getPresetIdByName('Default');

        if (! $presetId) {
            $this->warn('Could not find a "Default" embed preset on Vimeo. Preset assignment will be skipped.');
        } else {
            $this->line("Found \"Default\" preset ID: {$presetId}");
        }

        $this->newLine();

        if ($this->option('all')) {
            return $this->enableForAllCourses($vimeoService, $presetId);
        }

        $videoId = $this->argument('video_id');

        if (! $videoId) {
            $this->error('Please provide a video ID or use --all to process all course videos.');

            return self::FAILURE;
        }

        return $this->processVideo($vimeoService, (string) $videoId, $presetId) ? self::SUCCESS : self::FAILURE;
    }

    private function enableForAllCourses(VimeoService $vimeoService, ?string $presetId): int
    {
        /** @var Collection<int, string> $videoIds */
        $videoIds = new Collection();

        /** @var Collection<int, string> $tenants */
        $tenants = collect($this->option('tenants'))
            ->filter(static fn (mixed $tenant): bool => is_string($tenant) && $tenant !== '')
            ->values();

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function ($tenant) use ($videoIds): void {
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
        $this->info("Processing {$uniqueVideoIds->count()} unique video(s)...");
        $this->newLine();

        $passed = 0;
        $failed = 0;

        foreach ($uniqueVideoIds as $videoId) {
            if ($this->processVideo($vimeoService, (string) $videoId, $presetId)) {
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

    private function processVideo(VimeoService $vimeoService, string $videoId, ?string $presetId): bool
    {
        $this->line("Video ID: {$videoId}");

        $seekSuccess = $vimeoService->enableSeekButton($videoId);

        if ($seekSuccess) {
            $this->info('  ✓ Seek enabled');
        } else {
            $this->error('  ✗ Failed to enable seek');
        }

        if ($presetId) {
            $presetSuccess = $vimeoService->assignPreset($videoId, $presetId);

            if ($presetSuccess) {
                $this->info('  ✓ Default preset assigned');
            } else {
                $this->error('  ✗ Failed to assign Default preset');
            }

            return $seekSuccess && $presetSuccess;
        }

        return $seekSuccess;
    }
}
