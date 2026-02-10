<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Stancl\Tenancy\Concerns\HasATenantsOption;

class BackupSelfCheckCommand extends Command
{
    use HasATenantsOption;

    protected $signature = 'backups:check {--tenants=* : The tenant(s) to run the command for. Default all.} {--disk=armp-backups : Backup disk to check.}';
    protected $description = 'Verify each tenant has a backup in the last 24 hours';

    public function handle(): int
    {
        $disk = $this->option('disk');
        $cutoff = Carbon::now()->subDay()->getTimestamp();
        $failures = [];
        $checked = 0;

        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) use ($disk, $cutoff, &$failures, &$checked): void {
            $checked++;
            $tenantSlug = Str::slug($tenant->name) ?: 'tenant';
            $directory = "tenant-{$tenant->id}-{$tenantSlug}";

            $files = Storage::disk($disk)->allFiles($directory);
            if ($files === []) {
                $failures[] = "Tenant {$tenant->id} ({$tenant->name}): no backups found";

                return;
            }

            $latest = 0;
            foreach ($files as $file) {
                $modified = Storage::disk($disk)->lastModified($file);
                if ($modified > $latest) {
                    $latest = $modified;
                }
            }

            if ($latest < $cutoff) {
                $failures[] = "Tenant {$tenant->id} ({$tenant->name}): latest backup older than 24 hours";
            }
        });

        if ($failures !== []) {
            $this->error('Backup self-check failed for '.count($failures).' of '.$checked.' tenants.');
            foreach ($failures as $failure) {
                $this->line($failure);
            }

            return Command::FAILURE;
        }

        $this->info('Backup self-check passed for '.$checked.' tenants.');

        return Command::SUCCESS;
    }
}
