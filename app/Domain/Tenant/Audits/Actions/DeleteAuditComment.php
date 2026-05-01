<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Actions;

use App\Models\AuditComment;

class DeleteAuditComment
{
    public function handle(AuditComment $comment): void
    {
        $comment->clearMediaCollection('comment-photos');
        $comment->delete();
    }
}
