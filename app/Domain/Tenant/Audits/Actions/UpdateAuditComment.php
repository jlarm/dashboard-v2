<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Actions;

use App\Models\AuditComment;
use Illuminate\Http\UploadedFile;

class UpdateAuditComment
{
    public function handle(
        AuditComment $comment,
        string $body,
        ?UploadedFile $photo = null,
        bool $removePhoto = false,
    ): void {
        $comment->update(['comment' => $body]);

        if ($removePhoto) {
            $comment->getFirstMedia('comment-photos')?->delete();
        }

        if ($photo instanceof UploadedFile) {
            $comment->getFirstMedia('comment-photos')?->delete();
            $comment->addMedia($photo->getRealPath())
                ->usingFileName($photo->getClientOriginalName())
                ->toMediaCollection('comment-photos', 'armpaudits');
        }
    }
}
