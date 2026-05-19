<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealership;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Override;

class ClearLivewireTempFiles extends Command
{
    #[Override]
    protected $signature = 'livewire:clear-temp-files';

    #[Override]
    protected $description = 'Clear Livewire temporary files for all tenants';

    public function handle(): int
    {
        $this->info('Starting to clear Livewire temporary files for all tenants...');

        $totalFiles = 0;

        tenancy()->runForMultiple(Dealership::query()->pluck('id'), function (Dealership $tenant) use (&$totalFiles): void {
            $this->info("Processing tenant {$tenant->id} ({$tenant->name})...");

            $diskName = config('livewire.temporary_file_upload.disk');
            if (! is_string($diskName) || $diskName === '') {
                $diskName = (string) config('filesystems.default', 'local');
            }

            $directory = config('livewire.temporary_file_upload.directory');
            if (! is_string($directory) || $directory === '') {
                $directory = 'livewire-tmp';
            }

            $disk = Storage::disk($diskName);

            if ($disk->exists($directory)) {
                $files = $disk->allFiles($directory);
                $fileCount = count($files);

                if ($fileCount > 0) {
                    foreach ($files as $file) {
                        $disk->delete($file);
                    }
                    $totalFiles += $fileCount;
                    $this->comment("  Deleted {$fileCount} file(s) for tenant {$tenant->id}");
                } else {
                    $this->comment("  No files to delete for tenant {$tenant->id}");
                }
            } else {
                $this->comment("  No livewire-tmp directory found for tenant {$tenant->id}");
            }

            $this->info("Command for tenant {$tenant->id} ({$tenant->name}) completed");
        });

        $this->info("Total files deleted: {$totalFiles}");
        $this->comment('All done!');

        return Command::SUCCESS;
    }
}
