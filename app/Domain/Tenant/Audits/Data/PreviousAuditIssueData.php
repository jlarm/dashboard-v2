<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Data;

use App\Models\Dealer\Violation;

class PreviousAuditIssueData
{
    public function __construct(
        public readonly string $statement,
        public readonly ?int $severity,
        public readonly bool $risk,
        public readonly bool $remediationResolved,
    ) {}

    public static function fromModel(Violation $violation): self
    {
        $remediation = $violation->relationLoaded('remediation') ? $violation->remediation : null;

        return new self(
            statement: (string) ($violation->statement ?? ''),
            severity: $violation->severity !== null ? (int) $violation->severity : null,
            risk: (bool) $violation->risk,
            remediationResolved: $remediation !== null && (bool) $remediation->completed,
        );
    }

    /**
     * @return array{statement: string, severity: ?int, risk: bool, remediation_resolved: bool}
     */
    public function toArray(): array
    {
        return [
            'statement' => $this->statement,
            'severity' => $this->severity,
            'risk' => $this->risk,
            'remediation_resolved' => $this->remediationResolved,
        ];
    }
}
