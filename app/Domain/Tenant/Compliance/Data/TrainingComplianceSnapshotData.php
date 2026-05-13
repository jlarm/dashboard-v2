<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Data;

final readonly class TrainingComplianceSnapshotData
{
    /**
     * @param  list<TrainingComplianceAlertData>  $priority_alerts
     */
    public function __construct(
        public int $overdue,
        public int $at_risk,
        public int $compliant,
        public int $unassigned,
        public int $employees,
        public array $priority_alerts,
    ) {}

    /**
     * @return array{
     *     overdue:int,
     *     at_risk:int,
     *     compliant:int,
     *     unassigned:int,
     *     employees:int,
     *     priority_alerts: list<array{user_slug:string, name:string, valid_completed:int, total_required:int, status:string}>
     * }
     */
    public function toArray(): array
    {
        return [
            'overdue' => $this->overdue,
            'at_risk' => $this->at_risk,
            'compliant' => $this->compliant,
            'unassigned' => $this->unassigned,
            'employees' => $this->employees,
            'priority_alerts' => array_map(
                static fn (TrainingComplianceAlertData $alert): array => $alert->toArray(),
                $this->priority_alerts,
            ),
        ];
    }
}
