<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Data;

use App\Models\Dealer\Violation;

class ViolationData
{
    public function __construct(
        public readonly int $id,
        public readonly string $uuid,
        public readonly ?int $statementId,
        public readonly string $statement,
        public readonly string $comment,
        public readonly ?string $violationDate,
        public readonly bool $risk,
        public readonly ?int $severity,
        public readonly bool $showReferenceImage,
        public readonly ?string $referenceImageUrl,
        /** @var list<ViolationPhotoData> */
        public readonly array $photos,
        public readonly ?RemediationData $remediation,
    ) {}

    /**
     * @param  array<int, ?string>  $referenceImagesByStatementId
     */
    public static function fromModel(Violation $violation, array $referenceImagesByStatementId = []): self
    {
        $photos = [];
        foreach ([0, 1, 2] as $position) {
            foreach ($violation->getMedia('violation_files_'.$position) as $media) {
                $photos[] = new ViolationPhotoData(
                    id: (int) $media->getKey(),
                    position: $position,
                    url: $media->getFullUrl(),
                );
            }
        }

        return new self(
            id: (int) $violation->getKey(),
            uuid: (string) $violation->uuid,
            statementId: $violation->statement_id !== null ? (int) $violation->statement_id : null,
            statement: (string) $violation->statement,
            comment: (string) ($violation->comment ?? ''),
            violationDate: $violation->violation_date?->format('Y-m-d'),
            risk: (bool) $violation->risk,
            severity: $violation->severity !== null ? (int) $violation->severity : null,
            showReferenceImage: (bool) $violation->show_reference_image,
            referenceImageUrl: $violation->statement_id !== null
                ? ($referenceImagesByStatementId[$violation->statement_id] ?? null)
                : null,
            photos: $photos,
            remediation: $violation->remediation
                ? RemediationData::fromModel($violation->remediation)
                : null,
        );
    }

    /**
     * @return array{id: int, uuid: string, statement_id: ?int, statement: string, comment: string, violation_date: ?string, risk: bool, severity: ?int, show_reference_image: bool, reference_image_url: ?string, photos: list<array{id: int, position: int, url: string}>, remediation: ?array{id: int, comment: string, completed: bool, user_name: ?string, photo_url: ?string}}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'statement_id' => $this->statementId,
            'statement' => $this->statement,
            'comment' => $this->comment,
            'violation_date' => $this->violationDate,
            'risk' => $this->risk,
            'severity' => $this->severity,
            'show_reference_image' => $this->showReferenceImage,
            'reference_image_url' => $this->referenceImageUrl,
            'photos' => array_map(fn (ViolationPhotoData $p): array => $p->toArray(), $this->photos),
            'remediation' => $this->remediation?->toArray(),
        ];
    }
}
