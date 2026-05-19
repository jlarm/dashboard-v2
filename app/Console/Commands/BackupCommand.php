<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Override;
use Stancl\Tenancy\Concerns\HasATenantsOption;

class BackupCommand extends Command
{
    use HasATenantsOption;

    #[Override]
    protected $signature = 'backups:go {--tenants=* : The tenant(s) to run the command for. Default all.}';

    #[Override]
    protected $description = 'Run backup for tenant(s)';

    public function handle(): void
    {
        $total = 0;
        $successes = 0;
        $failures = [];

        /** @var Collection<int, string> $tenants */
        $tenants = collect($this->option('tenants'))
            ->filter(static fn (mixed $tenant): bool => is_string($tenant) && $tenant !== '')
            ->values();

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function (\App\Models\Dealership $tenant) use (&$total, &$successes, &$failures): void {
            $total++;
            $this->info("Running backup command for tenant {$tenant->id} ({$tenant->name})");

            try {
                $tenantSlug = Str::slug($tenant->name);
                config(['backup.backup.name' => "tenant-{$tenant->id}-{$tenantSlug}"]);
                $this->call('backup:run', [
                    '--filename' => 'tenant-'.$tenant->id.date('Y-m-d-H-i-s').'-.zip',
                    '--only-db' => true,
                ]);
                $this->info('Command completed successfully for '.$tenant->id.' ('.$tenant->name.')'.PHP_EOL);
                $successes++;
            } catch (Exception $e) {
                $this->error('Error running backup for tenant '.$tenant->id.' ('.$tenant->name.'): '.$e->getMessage());
                $failures[] = [
                    'id' => $tenant->id,
                    'name' => $tenant->name,
                    'error' => $e->getMessage(),
                ];
            }

        });

        $recipient = config('backup.notifications.mail.to', config('app.admin_email'));

        if ($recipient) {
            if ($failures !== []) {
                $subject = 'Tenant backups failed: '.count($failures)." of {$total}";
                $lines = [
                    'Tenant backup failures: '.count($failures)." of {$total}",
                    '',
                ];
                foreach ($failures as $failure) {
                    $lines[] = "Tenant {$failure['id']} ({$failure['name']}): {$failure['error']}";
                }
                Mail::raw(implode(PHP_EOL, $lines), function (\Illuminate\Mail\Message $message) use ($recipient, $subject): void {
                    $message->to($recipient)->subject($subject);
                });
            } else {
                $subject = "Tenant backups successful: {$successes} of {$total}";
                Mail::raw("All tenant backups completed successfully. Total: {$successes}", function (\Illuminate\Mail\Message $message) use ($recipient, $subject): void {
                    $message->to($recipient)->subject($subject);
                });
            }
        }
    }
}
