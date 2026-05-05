<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Data;

final readonly class AuditTrackerRowData
{
    /**
     * @param  'passing'|'action_required'|'overdue'  $status
     */
    public function __construct(
        public string $type_key,
        public string $type_label,
        public ?string $last_audit_date,
        public ?string $grade,
        public ?string $delta_label,
        public string $status,
        public bool $has_report,
    ) {}

    /**
     * @return array{
     *     type_key:string,
     *     type_label:string,
     *     last_audit_date:?string,
     *     grade:?string,
     *     delta_label:?string,
     *     status:'passing'|'action_required'|'overdue',
     *     has_report:bool,
     * }
     */
    public function toArray(): array
    {
        return [
            'type_key' => $this->type_key,
            'type_label' => $this->type_label,
            'last_audit_date' => $this->last_audit_date,
            'grade' => $this->grade,
            'delta_label' => $this->delta_label,
            'status' => $this->status,
            'has_report' => $this->has_report,
        ];
    }
}
