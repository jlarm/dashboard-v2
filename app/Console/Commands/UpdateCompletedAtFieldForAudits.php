<?php

namespace App\Console\Commands;

use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use Illuminate\Console\Command;

class UpdateCompletedAtFieldForAudits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audit:update-completed-at-field {--tenants=* : The tenant(s) to run the command for. Default all.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update completed_at field for audits';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
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
