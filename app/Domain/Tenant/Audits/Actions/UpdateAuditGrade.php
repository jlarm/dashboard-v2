<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Actions;

use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UpdateAuditGrade
{
    public function handle(ViolationAudit&Model $audit, User $user, string $grade): void
    {
        $audit->update([
            'grade' => $grade,
            'grade_updated_by' => $user->id,
            'grade_updated_at' => now(),
        ]);
    }
}
