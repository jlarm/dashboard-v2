<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Actions;

use App\Enums\ViolationAuditType;
use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use Illuminate\Database\Eloquent\Model;

class DispatchRemediationPdfGeneration
{
    public function handle(ViolationAuditType $type, ViolationAudit&Model $audit): void
    {
        $jobClass = $type->generateRemediationPdfJobClass();
        dispatch(new $jobClass($audit));
    }
}
