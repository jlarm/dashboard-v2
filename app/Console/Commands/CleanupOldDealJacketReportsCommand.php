<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanupOldDealJacketReportsCommand extends Command
{
    protected $signature = 'deal-jacket-reports:clean {--tenants=* : The tenant(s) to run the command for. Default all.}';
    protected $description = 'Delete deal jacket reports older than 24 hours';

    public function handle(): int
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant): void {
            $path = storage_path('app/deal-jacket-reports');

            if (! File::isDirectory($path)) {
                $this->comment("Deal Jacket Reports directory does not exist for tenant {$tenant->id}.");

                return;
            }

            $files = File::files($path);
            $deleteCount = 0;
            $cutoffTime = now()->subHours(24)->timestamp;

            foreach ($files as $file) {
                $lastModified = $file->getMTime();

                if ($lastModified < $cutoffTime) {
                    $this->info("Deleting file: {$file->getFilename()}");

                    File::delete($file->getPathname());
                    $deleteCount++;
                }
            }

            $this->comment("Deleted {$deleteCount} deal jacket report(s).");
        });

        return Command::SUCCESS;
    }
}
