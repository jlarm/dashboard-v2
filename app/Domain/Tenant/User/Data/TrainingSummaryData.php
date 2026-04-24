<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Data;

/**
 * @phpstan-type TrainingComplianceStatus 'compliant'|'at_risk'|'overdue'|'unassigned'
 */
final readonly class TrainingSummaryData
{
    /**
     * @param  TrainingComplianceStatus  $status
     */
    public function __construct(
        public int $totalRequired,
        public int $validCompleted,
        public int $notCompleted,
        public int $expired,
        public int $expiringSoon,
        public string $status,
    ) {}

    /**
     * @param  array{
     *     total_required: int,
     *     valid_completed: int,
     *     not_completed: int,
     *     expired: int,
     *     expiring_soon: int,
     *     status: TrainingComplianceStatus
     * }  $summary
     */
    public static function fromArray(array $summary): self
    {
        return new self(
            totalRequired: $summary['total_required'],
            validCompleted: $summary['valid_completed'],
            notCompleted: $summary['not_completed'],
            expired: $summary['expired'],
            expiringSoon: $summary['expiring_soon'],
            status: $summary['status'],
        );
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'compliant' => 'Compliant',
            'overdue' => 'Overdue',
            'at_risk' => 'At Risk',
            'unassigned' => 'Unassigned',
        };
    }

    /**
     * @return array{
     *     total_required: int,
     *     valid_completed: int,
     *     not_completed: int,
     *     expired: int,
     *     expiring_soon: int,
     *     status: TrainingComplianceStatus,
     *     status_label: string
     * }
     */
    public function toArray(): array
    {
        return [
            'total_required' => $this->totalRequired,
            'valid_completed' => $this->validCompleted,
            'not_completed' => $this->notCompleted,
            'expired' => $this->expired,
            'expiring_soon' => $this->expiringSoon,
            'status' => $this->status,
            'status_label' => $this->statusLabel(),
        ];
    }
}
