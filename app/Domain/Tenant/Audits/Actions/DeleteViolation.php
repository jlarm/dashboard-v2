<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Actions;

use App\Models\Dealer\Violation;

class DeleteViolation
{
    public function handle(Violation $violation): void
    {
        foreach ([0, 1, 2] as $position) {
            $violation->clearMediaCollection('violation_files_'.$position);
            $violation->clearMediaCollection('violations_files_'.$position);
        }

        $violation->delete();
    }
}
