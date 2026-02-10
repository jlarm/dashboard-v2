<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealer\Course;
use Illuminate\Console\Command;

class AddVideoToCourseCommand extends Command
{
    protected $signature = 'video:to-course {slug : The course slug} {video_id : The video ID} {--tenants=* : The tenant(s) to run the command for. Default all.}';
    protected $description = 'Add video id to course';

    public function handle(): void
    {
        $slug = $this->argument('slug');
        $videoId = $this->argument('video_id');

        $this->info("Adding video ID '{$videoId}' to course with slug '{$slug}'");

        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) use ($slug, $videoId): void {
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
