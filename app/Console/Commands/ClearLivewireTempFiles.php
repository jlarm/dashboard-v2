<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealership;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearLivewireTempFiles extends Command
{
    protected $signature = 'livewire:clear-temp-files';
    protected $description = 'Clear Livewire temporary files for all tenants';

    public function handle(): int
    {
        $this->info('Starting to clear Livewire temporary files for all tenants...');

        $tenants = Dealership::all();
        $totalFiles = 0;
        $processedTenants = 0;

        $tenants->each(function (Dealership $tenant) use (&$totalFiles, &$processedTenants) {
            $this->info("Processing tenant: {$tenant->id}...");

            tenancy()->initialize($tenant);

            $livewireTmpPath = storage_path('app/livewire-tmp');

            if (File::exists($livewireTmpPath)) {
                $files = File::allFiles($livewireTmpPath);
                $fileCount = count($files);

                if ($fileCount > 0) {
                    File::cleanDirectory($livewireTmpPath);
                    $totalFiles += $fileCount;
                    $this->comment("  Deleted {$fileCount} file(s) for tenant {$tenant->id}");
                } else {
                    $this->comment("  No files to delete for tenant {$tenant->id}");
                }
            } else {
                $this->comment("  No livewire-tmp directory found for tenant {$tenant->id}");
            }

            $processedTenants++;
        });

        $this->info("Processed {$processedTenants} tenant(s).");
        $this->info("Total files deleted: {$totalFiles}");
        $this->comment('All done!');

        return Command::SUCCESS;
    }
}
