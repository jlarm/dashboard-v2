<?php

declare(strict_types=1);

namespace App\Domain\Tenant\IndividualAudits\Queries;

use App\Domain\Tenant\IndividualAudits\Data\IndividualAuditDetail;
use App\Models\Dealer\Audit\IndividualAudit;

class LoadIndividualAuditDetail
{
    public function handle(IndividualAudit $audit): IndividualAuditDetail
    {
        $audit->loadMissing([
            'store',
            'manager',
            'children.manager',
            'media',
        ]);

        return IndividualAuditDetail::fromModel($audit);
    }
}
