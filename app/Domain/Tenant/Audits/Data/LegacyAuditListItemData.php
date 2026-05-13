<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Data;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class LegacyAuditListItemData
{
    public function __construct(
        public readonly int $id,
        public readonly string $auditDate,
        public readonly string $quarter,
        public readonly ?string $grade,
        public readonly bool $hasPdf,
    ) {}

    public static function fromModel(Model $legacy): self
    {
        /** @var Carbon $date */
        $date = $legacy->audit_date; // @phpstan-ignore property.notFound
        $rating = (int) ($legacy->rating ?? 0);

        return new self(
            id: (int) $legacy->getKey(),
            auditDate: $date->format('Y-m-d'),
            quarter: $date->format('Y').' Q'.(int) ceil((int) $date->format('n') / 3),
            grade: match (true) {
                $rating >= 90 => 'A',
                $rating >= 80 => 'B',
                $rating >= 70 => 'C',
                $rating >= 60 => 'D',
                $rating >= 50 => 'F',
                default => null,
            },
            hasPdf: ! empty($legacy->pdf_path),
        );
    }

    /**
     * @return array{id: int, audit_date: string, quarter: string, grade: ?string, has_pdf: bool}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'audit_date' => $this->auditDate,
            'quarter' => $this->quarter,
            'grade' => $this->grade,
            'has_pdf' => $this->hasPdf,
        ];
    }
}
