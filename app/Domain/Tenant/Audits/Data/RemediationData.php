<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Data;

use App\Models\Remediation;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Throwable;

class RemediationData
{
    public function __construct(
        public readonly int $id,
        public readonly string $comment,
        public readonly bool $completed,
        public readonly ?string $userName,
        public readonly ?string $photoUrl,
        public readonly ?string $updatedAt,
    ) {}

    public static function fromModel(Remediation $remediation): self
    {
        $photo = $remediation->getFirstMedia('remediations');
        $photoUrl = null;
        if ($photo instanceof Media) {
            try {
                $photoUrl = $photo->getTemporaryUrl(now()->addMinutes(45));
            } catch (Throwable) {
                $photoUrl = null;
            }
        }

        return new self(
            id: (int) $remediation->getKey(),
            comment: (string) ($remediation->comment ?? ''),
            completed: (bool) $remediation->completed,
            userName: $remediation->user?->name,
            photoUrl: $photoUrl,
            updatedAt: $remediation->updated_at?->toIso8601String(),
        );
    }

    /**
     * @return array{id: int, comment: string, completed: bool, user_name: ?string, photo_url: ?string, updated_at: ?string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'completed' => $this->completed,
            'user_name' => $this->userName,
            'photo_url' => $this->photoUrl,
            'updated_at' => $this->updatedAt,
        ];
    }
}
