<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Stancl\Tenancy\Concerns\HasATenantsOption;

class BackupCommand extends Command
{
    use HasATenantsOption;

    protected $signature = 'backups:go {--tenants=* : The tenant(s) to run the command for. Default all.}';
    protected $description = 'Run backup for tenant(s)';

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
            $this->info("Running backup command for tenant {$tenant->id} ({$tenant->name})");

            try {
                $this->call('backup:run', [
                    '--filename' => 'tenant-'.$tenant->id.date('Y-m-d-H-i-s').'-.zip',
                    '--only-db' => true,
                ]);
                $this->info('Command completed successfully for '.$tenant->id.' ('.$tenant->name.')'.PHP_EOL);
            } catch (Exception $e) {
                $this->error('Error running backup for tenant '.$tenant->id.' ('.$tenant->name.'): '.$e->getMessage());
            }

        });
    }
}
