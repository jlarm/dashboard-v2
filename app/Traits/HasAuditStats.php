<?php

namespace App\Traits;

trait HasAuditStats
{
    public function progress(): ?array
    {
        if ($this->violationAudits()->whereNotNull('grade')->get()->count() < 2) {
            return null;
        }

        $latestAudits = $this->violationAudits()
            ->orderBy('date', 'desc')
            ->take(2)
            ->get();

        $first = $latestAudits->first()->violations()->count();
        $second = $latestAudits->last()->violations()->count();

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
