<?php

declare(strict_types=1);

namespace App\Domain\Tenant\IndividualAudits\Actions;

use App\Jobs\GenerateIndividualAuditPdfJob;
use App\Jobs\UploadIndividualAuditToDigitalOceanJob;
use App\Models\Dealer\Audit\IndividualAudit;
use Illuminate\Support\Facades\Bus;

class DispatchIndividualAuditPdfGeneration
{
    public function handle(IndividualAudit $audit): void
    {
        Bus::chain([
            new GenerateIndividualAuditPdfJob($audit),
            new UploadIndividualAuditToDigitalOceanJob($audit),
        ])->dispatch();
    }
}
