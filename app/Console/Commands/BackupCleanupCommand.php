<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Override;
use Stancl\Tenancy\Concerns\HasATenantsOption;

class BackupCleanupCommand extends Command
{
    use HasATenantsOption;

    #[Override]
    protected $signature = 'backups:clean {--tenants=* : The tenant(s) to run the command for. Default all.}';

    #[Override]
    protected $description = 'Run backup cleanup for tenant(s)';

    public function handle(): void
    {
        /** @var Collection<int, string> $tenants */
        $tenants = collect($this->option('tenants'))
            ->filter(static fn (mixed $tenant): bool => is_string($tenant) && $tenant !== '')
            ->values();

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function (\App\Models\Dealership $tenant): void {
            $this->info("Running backup cleanup command for tenant {$tenant->id} ({$tenant->name})");

            try {
                $this->call('backup:clean');
                $this->info('Command completed successfully for '.$tenant->id.' ('.$tenant->name.')'.PHP_EOL);
            } catch (Exception $e) {
                $this->error('Error running backup cleanup for tenant '.$tenant->id.' ('.$tenant->name.'): '.$e->getMessage());
            }

        });
    }
}
