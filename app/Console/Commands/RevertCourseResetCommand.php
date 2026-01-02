<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealer\CourseResults;
use App\Models\Dealership;
use Illuminate\Console\Command;

class RevertCourseResetCommand extends Command
{
    protected $signature = 'revert:course-reset {tenant : The tenant UUID}';
    protected $description = 'Restore soft-deleted course results for a specific tenant';

    public function handle(): void
    {
        $tenantId = $this->argument('tenant');

        $tenant = Dealership::find($tenantId);

        if (! $tenant) {
            $this->error("Tenant with UUID {$tenantId} not found");

            return;
        }

        $this->info("Restoring course results for tenant {$tenant->name}");

        $tenant->run(function () {
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
