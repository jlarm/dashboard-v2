<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Data;

use App\Models\AuditComment;

class AuditCommentData
{
    public function __construct(
        public readonly int $id,
        public readonly int $userId,
        public readonly string $userName,
        public readonly string $comment,
        public readonly string $createdAt,
    ) {}

    public static function fromModel(AuditComment $comment): self
    {
        return new self(
            id: (int) $comment->getKey(),
            userId: (int) $comment->user_id,
            userName: (string) ($comment->user?->name ?? 'Unknown'),
            comment: (string) $comment->comment,
            createdAt: $comment->created_at?->toIso8601String() ?? '',
        );
    }

    /**
     * @return array{id: int, user_id: int, user_name: string, comment: string, created_at: string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'user_name' => $this->userName,
            'comment' => $this->comment,
            'created_at' => $this->createdAt,
        ];
    }
}
