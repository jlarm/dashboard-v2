<?php

declare(strict_types=1);

namespace App\Domain\Tenant\IndividualAudits\Data;

use App\Models\Dealer\Audit\IndividualAudit;

class IndividualAuditListItem
{
    public function __construct(
        public readonly int $id,
        public readonly string $uuid,
        public readonly string $auditDate,
        public readonly string $quarter,
        public readonly int $year,
        public readonly bool $hasPdf,
        public readonly int $childCount,
        public readonly int $draftCount,
    ) {}

    public static function fromModel(IndividualAudit $audit): self
    {
        $month = $audit->audit_date?->month ?? 1;
        $quarter = match (true) {
            $month <= 3 => 'Q1',
            $month <= 6 => 'Q2',
            $month <= 9 => 'Q3',
            default => 'Q4',
        };

        return new self(
            id: (int) $audit->id,
            uuid: (string) $audit->uuid,
            auditDate: $audit->audit_date?->toDateString() ?? '',
            quarter: $quarter,
            year: (int) ($audit->audit_date?->year ?? now()->year),
            hasPdf: (bool) ($audit->pdf_path ?? false),
            childCount: (int) ($audit->children_count ?? $audit->children?->count() ?? 0),
            draftCount: (int) ($audit->draft_count ?? 0),
        );
    }

    /**
     * @return array{id: int, uuid: string, audit_date: string, quarter: string, year: int, has_pdf: bool, child_count: int, draft_count: int}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'audit_date' => $this->auditDate,
            'quarter' => $this->quarter,
            'year' => $this->year,
            'has_pdf' => $this->hasPdf,
            'child_count' => $this->childCount,
            'draft_count' => $this->draftCount,
        ];
    }
}
