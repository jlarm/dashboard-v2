<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealer\Course;
use App\Models\Dealership;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Override;

class AddVideoToCourseCommand extends Command
{
    #[Override]
    protected $signature = 'video:to-course {slug : The course slug} {video_id : The video ID} {--tenants=* : The tenant(s) to run the command for. Default all.}';

    #[Override]
    protected $description = 'Add video id to course';

    public function handle(): void
    {
        $slug = $this->argument('slug');
        $videoId = $this->argument('video_id');

        $this->info("Adding video ID '{$videoId}' to course with slug '{$slug}'");

        /** @var Collection<int, string> $tenants */
        $tenants = collect($this->option('tenants'))
            ->filter(static fn (mixed $tenant): bool => is_string($tenant) && $tenant !== '')
            ->values();

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function (Dealership $tenant) use ($slug, $videoId): void {
            $this->info("Processing tenant: {$tenant->id}");

            $course = Course::query()->where('slug', $slug)->first();

            if (! $course) {
                $this->error("Course with slug '{$slug}' not found");

                return;
            }

            $course->update(['video_id' => $videoId]);

            $this->comment("Successfully updated course '{$course->name}'");
        });

        $this->info('Command completed');
    }
}
