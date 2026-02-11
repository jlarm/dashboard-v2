<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method HasMany violationAudits()
 */
trait HasAuditStats
{
    public function progress(): ?array
    {
        $gradedAudits = $this->violationAudits()
            ->whereNotNull('grade')
            ->where('grade', '!=', 'N/A');

        if ((clone $gradedAudits)->count() < 2) {
            return null;
        }

        $latestAudits = (clone $gradedAudits)
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->take(2)
            ->get();

        $firstAudit = $latestAudits->first();
        $secondAudit = $latestAudits->last();
        $first = method_exists($firstAudit, 'violations') ? $firstAudit->violations()->count() : 0;
        $second = method_exists($secondAudit, 'violations') ? $secondAudit->violations()->count() : 0;

        $comparison = $first - $second;

        if ($comparison === 0) {
            return null;
        }
        if ($comparison < 0) {
            return ['positive', abs($comparison)];
        }

        return ['negative', $comparison];

    }
}
