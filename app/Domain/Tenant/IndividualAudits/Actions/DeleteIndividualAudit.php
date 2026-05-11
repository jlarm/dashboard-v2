<?php

declare(strict_types=1);

namespace App\Domain\Tenant\IndividualAudits\Actions;

use App\Models\Dealer\Audit\IndividualAudit;

class DeleteIndividualAudit
{
    public function handle(IndividualAudit $audit): void
    {
        $audit->delete();
    }
}
