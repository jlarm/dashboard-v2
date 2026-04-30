<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Data;

use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use Illuminate\Database\Eloquent\Model;

class ViolationAuditListItemData
{
    public function __construct(
        public readonly int $id,
        public readonly string $uuid,
        public readonly string $date,
        public readonly string $quarter,
        public readonly ?string $grade,
        public readonly int $violationCount,
        public readonly int $remediationCount,
        public readonly int $remediationProgress,
        public readonly int $commentCount,
        public readonly bool $hasPdf,
        public readonly bool $hasRemediationPdf,
        public readonly string $storeName,
    ) {}

    public static function fromModel(ViolationAudit&Model $audit): self
    {
        $violationCount = (int) ($audit->violation_count ?? 0);
        $remediationCount = (int) ($audit->remediation_count ?? 0);
        $progress = $violationCount === 0 ? 0 : (int) round(($remediationCount / $violationCount) * 100);

        return new self(
            id: (int) $audit->getKey(),
            uuid: (string) $audit->uuid,
            date: $audit->date->format('Y-m-d'),
            quarter: $audit->date->format('Y').' Q'.(int) ceil((int) $audit->date->format('n') / 3),
            grade: $audit->grade,
            violationCount: $violationCount,
            remediationCount: $remediationCount,
            remediationProgress: $progress,
            commentCount: (int) ($audit->audit_comments_count ?? 0),
            hasPdf: ! empty($audit->pdf_path),
            hasRemediationPdf: ! empty($audit->remediation_pdf_path),
            storeName: (string) ($audit->store?->name ?? ''),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'date' => $this->date,
            'quarter' => $this->quarter,
            'grade' => $this->grade,
            'violation_count' => $this->violationCount,
            'remediation_count' => $this->remediationCount,
            'remediation_progress' => $this->remediationProgress,
            'comment_count' => $this->commentCount,
            'has_pdf' => $this->hasPdf,
            'has_remediation_pdf' => $this->hasRemediationPdf,
            'store_name' => $this->storeName,
        ];
    }
}
