<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stancl\Tenancy\Concerns\HasATenantsOption;

class BackupCleanupCommand extends Command
{
    use HasATenantsOption;

    protected $signature = 'backups:clean {--tenants=* : The tenant(s) to run the command for. Default all.}';

    protected $description = 'Run backup cleanup for tenant(s)';

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
            $this->info("Running backup cleanup command for tenant {$tenant->id} ({$tenant->name})");

            try {
                $this->call('backup:clean');
                $this->info('Command completed successfully for '.$tenant->id.' ('.$tenant->name.')'.PHP_EOL);
            } catch (\Exception $e) {
                $this->error('Error running backup cleanup for tenant '.$tenant->id.' ('.$tenant->name.'): '.$e->getMessage());
            }

        });
    }
}
