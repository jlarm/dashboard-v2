<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Data;

use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use Illuminate\Database\Eloquent\Model;

class ViolationAuditDetailData
{
    public function __construct(
        public readonly int $id,
        public readonly string $uuid,
        public readonly string $date,
        public readonly ?string $grade,
        public readonly int $violationCount,
        public readonly int $remediationCount,
        public readonly int|string $rating,
        public readonly bool $hasPdf,
        public readonly bool $hasRemediationPdf,
        public readonly string $storeName,
        /** @var list<ViolationData> */
        public readonly array $violations,
        /** @var list<AuditCommentData> */
        public readonly array $comments,
    ) {}

    /**
     * @param  list<ViolationData>  $violations
     * @param  list<AuditCommentData>  $comments
     */
    public static function fromModel(
        ViolationAudit&Model $audit,
        array $violations,
        array $comments,
    ): self {
        $count = count($violations);
        $remediationCount = 0;
        foreach ($violations as $violation) {
            if ($violation->remediation?->completed) {
                $remediationCount++;
            }
        }

        return new self(
            id: (int) $audit->getKey(),
            uuid: (string) $audit->uuid,
            date: $audit->date->format('Y-m-d'),
            grade: $audit->grade,
            violationCount: $count,
            remediationCount: $remediationCount,
            rating: match (true) {
                $count === 0 => 99,
                $count <= 10 => 75,
                $count <= 20 => 50,
                $count <= 30 => 25,
                $count <= 40 => 10,
                $count <= 50 => 5,
                default => 'N/A',
            },
            hasPdf: ! empty($audit->pdf_path),
            hasRemediationPdf: ! empty($audit->remediation_pdf_path),
            storeName: (string) ($audit->store->name ?? ''),
            violations: $violations,
            comments: $comments,
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
            'grade' => $this->grade,
            'violation_count' => $this->violationCount,
            'remediation_count' => $this->remediationCount,
            'rating' => $this->rating,
            'has_pdf' => $this->hasPdf,
            'has_remediation_pdf' => $this->hasRemediationPdf,
            'store_name' => $this->storeName,
            'violations' => array_map(fn (ViolationData $v): array => $v->toArray(), $this->violations),
            'comments' => array_map(fn (AuditCommentData $c): array => $c->toArray(), $this->comments),
        ];
    }
}
