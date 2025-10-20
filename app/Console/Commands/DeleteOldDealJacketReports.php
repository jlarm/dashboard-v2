<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DeleteOldDealJacketReports extends Command
{
    protected $signature = 'deal-jacket-reports:cleanup';
    protected $description = 'Delete deal jacket reports older than 24 hours';

    public function handle(): int
    {
        $path = storage_path('app/deal-jacket-reports');

        if (! File::isDirectory($path)) {
            $this->info('No reports directory found.');

            return self::SUCCESS;
        }

        $files = File::files($path);
        $deletedCount = 0;
        $cutoffTime = now()->subHours(24)->timestamp;

        foreach ($files as $file) {
            $fileModifiedTime = File::lastModified($file->getPathname());

            if ($fileModifiedTime < $cutoffTime) {
                $this->info("Deleting old report: {$file->getFilename()}");
                File::delete($file->getPathname());
                $deletedCount++;
            }
        }

        $this->comment("Deleted {$deletedCount} old deal jacket report(s).");

        return self::SUCCESS;
    }
}
