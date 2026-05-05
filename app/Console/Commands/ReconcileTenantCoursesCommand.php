<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Domain\Central\Courses\Actions\ReconcileTenantCourses;
use Illuminate\Console\Command;

class ReconcileTenantCoursesCommand extends Command
{
    protected $signature = 'courses:reconcile-tenants {--force : Apply changes. Without this flag the command runs in dry-run mode.}';
    protected $description = 'Sync per-tenant course copies to match the central course_tenant assignments. Soft-deletes tenant copies that fall out of scope; restores ones that come back into scope.';

    public function handle(ReconcileTenantCourses $action): int
    {
        $apply = (bool) $this->option('force');

        if (! $apply) {
            $this->warn('Dry-run mode. Re-run with --force to apply changes.');
        }

        $stats = $action->handle($apply, function (string $message): void {
            $this->line($message);
        });

        $this->newLine();
        $this->table(
            ['Metric', 'Count'],
            [
                ['Tenants checked', $stats['tenants_checked']],
                ['Tenant courses to soft-delete', $stats['soft_deleted']],
                ['Tenant courses to restore', $stats['restored']],
            ],
        );

        if (! $apply && ($stats['soft_deleted'] > 0 || $stats['restored'] > 0)) {
            $this->comment('Re-run with --force to apply.');
        }

        return self::SUCCESS;
    }
}
