<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealer\CourseResults;
use App\Models\Dealership;
use Illuminate\Console\Command;
use Override;

class RevertCourseResetCommand extends Command
{
    #[Override]
    protected $signature = 'revert:course-reset {tenant : The tenant UUID}';

    #[Override]
    protected $description = 'Restore soft-deleted course results for a specific tenant';

    public function handle(): void
    {
        $tenantId = $this->argument('tenant');

        $tenant = Dealership::query()->find($tenantId);

        if (! $tenant) {
            $this->error("Tenant with UUID {$tenantId} not found");

            return;
        }

        $this->info("Restoring course results for tenant {$tenant->name}");

        $tenant->run(function (): void {
            $restoredCount = CourseResults::onlyTrashed()->count();

            if ($restoredCount === 0) {
                $this->info('No course results to restore');

                return;
            }

            CourseResults::onlyTrashed()->restore();

            $this->info("Successfully restored {$restoredCount} course results");
        });
    }
}
