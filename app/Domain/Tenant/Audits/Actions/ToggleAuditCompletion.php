<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Actions;

use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use Illuminate\Database\Eloquent\Model;

class ToggleAuditCompletion
{
    public function complete(ViolationAudit&Model $audit): void
    {
        $audit->update(['completed_date' => now()]);
    }

    public function reopen(ViolationAudit&Model $audit): void
    {
        $audit->update(['completed_date' => null]);
    }
}
