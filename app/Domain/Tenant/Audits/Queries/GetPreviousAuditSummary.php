<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Queries;

use App\Domain\Tenant\Audits\Data\PreviousAuditIssueData;
use App\Domain\Tenant\Audits\Data\PreviousAuditSummaryData;
use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use App\Models\Dealer\Violation;
use Illuminate\Database\Eloquent\Model;

class GetPreviousAuditSummary
{
    /**
     * Summarise the most recent completed audit for the same store, so the
     * consultant starting a new audit knows which issues to look out for.
     */
    public function handle(ViolationAudit&Model $currentAudit): ?PreviousAuditSummaryData
    {
        /** @var (ViolationAudit&Model)|null $previous */
        $previous = $currentAudit->newQuery()
            ->where('store_id', $currentAudit->store_id)
            ->whereKeyNot($currentAudit->getKey())
            ->whereNotNull('completed_date')
            ->with(['violations.remediation'])
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->first();

        if ($previous === null) {
            return null;
        }

        $issues = $previous->violations
            ->map(static fn (Violation $violation): PreviousAuditIssueData => PreviousAuditIssueData::fromModel($violation))
            ->sortBy([
                static fn (PreviousAuditIssueData $issue): int => $issue->remediationResolved ? 1 : 0,
                static fn (PreviousAuditIssueData $issue): int => $issue->risk ? 0 : 1,
                static fn (PreviousAuditIssueData $issue): int => -($issue->severity ?? 0),
            ])
            ->values()
            ->all();

        $openRemediationCount = count(array_filter(
            $issues,
            static fn (PreviousAuditIssueData $issue): bool => ! $issue->remediationResolved,
        ));

        return new PreviousAuditSummaryData(
            uuid: (string) $previous->uuid,
            date: $previous->date->format('Y-m-d'),
            grade: $previous->grade,
            violationCount: count($issues),
            openRemediationCount: $openRemediationCount,
            issues: $issues,
        );
    }
}
