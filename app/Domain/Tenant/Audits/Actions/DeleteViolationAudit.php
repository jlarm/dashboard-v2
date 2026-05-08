<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Actions;

use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use App\Models\Dealer\Violation;
use Illuminate\Database\Eloquent\Model;

class DeleteViolationAudit
{
    public function handle(ViolationAudit&Model $audit): void
    {
        $audit->violations()->each(function (Violation $violation): void { // @phpstan-ignore argument.type
            foreach ([0, 1, 2] as $position) {
                $violation->clearMediaCollection('violation_files_'.$position);
                $violation->clearMediaCollection('violations_files_'.$position);
            }
        });

        $audit->auditComments()->delete();
        $audit->delete();
    }
}
