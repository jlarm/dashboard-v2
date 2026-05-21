<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Data;

class PreviousAuditSummaryData
{
    /**
     * @param  list<PreviousAuditIssueData>  $issues
     */
    public function __construct(
        public readonly string $uuid,
        public readonly string $date,
        public readonly ?string $grade,
        public readonly int $violationCount,
        public readonly int $openRemediationCount,
        public readonly array $issues,
    ) {}

    /**
     * @return array{uuid: string, date: string, grade: ?string, violation_count: int, open_remediation_count: int, issues: list<array{statement: string, severity: ?int, risk: bool, remediation_resolved: bool}>}
     */
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'date' => $this->date,
            'grade' => $this->grade,
            'violation_count' => $this->violationCount,
            'open_remediation_count' => $this->openRemediationCount,
            'issues' => array_map(
                static fn (PreviousAuditIssueData $issue): array => $issue->toArray(),
                $this->issues,
            ),
        ];
    }
}
