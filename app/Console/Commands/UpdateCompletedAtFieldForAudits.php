<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Override;

class UpdateCompletedAtFieldForAudits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    #[Override]
    protected $signature = 'audit:update-completed-at-field {--tenants=* : The tenant(s) to run the command for. Default all.}';

    /**
     * The console command description.
     *
     * @var string
     */
    #[Override]
    protected $description = 'Update completed_at field for audits';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        /** @var Collection<int, string> $tenants */
        $tenants = collect($this->option('tenants'))
            ->filter(static fn (mixed $tenant): bool => is_string($tenant) && $tenant !== '')
            ->values();

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function ($tenant): void {
            $this->info("Running command for tenant {$tenant->id} ({$tenant->name})");

            $this->updateAudits(OshaViolationAudit::class);
            $this->updateAudits(GlbaViolationAudit::class);
            $this->updateAudits(BodyShopViolationAudit::class);
        });
    }

    private function updateAudits(string $auditModelClass): void
    {
        $audits = $auditModelClass::whereNotNull('pdf_path')->whereNull('completed_date')->get();

        if ($audits->isEmpty()) {
            $this->info("No incomplete {$auditModelClass} audits found.");

            return;
        }

        $this->info('Updating '.count($audits)." incomplete {$auditModelClass} audits.");

        foreach ($audits as $audit) {
            $audit->update(['completed_date' => $audit->updated_at]);
            $this->info('Updated audit: '.$audit->id);
        }
    }
}
