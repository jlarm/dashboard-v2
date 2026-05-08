<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Data;

use App\Models\AuditComment;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Throwable;

class AuditCommentData
{
    public function __construct(
        public readonly int $id,
        public readonly int $userId,
        public readonly string $userName,
        public readonly string $comment,
        public readonly string $createdAt,
        public readonly ?string $photoUrl,
    ) {}

    public static function fromModel(AuditComment $comment): self
    {
        $photo = $comment->getFirstMedia('comment-photos');
        $photoUrl = null;
        if ($photo instanceof Media) {
            try {
                $photoUrl = $photo->getTemporaryUrl(now()->addMinutes(45));
            } catch (Throwable) {
                $photoUrl = null;
            }
        }

        return new self(
            id: (int) $comment->getKey(),
            userId: (int) $comment->user_id,
            userName: (string) ($comment->user->name ?? 'Unknown'),
            comment: (string) $comment->comment,
            createdAt: $comment->created_at?->toIso8601String() ?? '',
            photoUrl: $photoUrl,
        );
    }

    /**
     * @return array{id: int, user_id: int, user_name: string, comment: string, created_at: string, photo_url: ?string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'user_name' => $this->userName,
            'comment' => $this->comment,
            'created_at' => $this->createdAt,
            'photo_url' => $this->photoUrl,
        ];
    }
}
