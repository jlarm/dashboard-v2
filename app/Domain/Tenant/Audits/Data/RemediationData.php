<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Data;

use App\Models\Remediation;

class RemediationData
{
    public function __construct(
        public readonly int $id,
        public readonly string $comment,
        public readonly bool $completed,
        public readonly ?string $userName,
        public readonly ?string $photoUrl,
    ) {}

    public static function fromModel(Remediation $remediation): self
    {
        $photo = $remediation->getFirstMedia('remediations');

        return new self(
            id: (int) $remediation->getKey(),
            comment: (string) ($remediation->comment ?? ''),
            completed: (bool) $remediation->completed,
            userName: $remediation->user?->name,
            photoUrl: $photo?->getFullUrl(),
        );
    }

    /**
     * @return array{id: int, comment: string, completed: bool, user_name: ?string, photo_url: ?string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'completed' => $this->completed,
            'user_name' => $this->userName,
            'photo_url' => $this->photoUrl,
        ];
    }
}
