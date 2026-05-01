<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Actions;

use App\Models\AuditComment;
use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class CreateAuditComment
{
    public function handle(
        ViolationAudit&Model $audit,
        User $user,
        string $comment,
        ?UploadedFile $photo = null,
    ): AuditComment {
        /** @var AuditComment $created */
        $created = $audit->auditComments()->create([
            'user_id' => $user->id,
            'comment' => $comment,
        ]);

        if ($photo instanceof UploadedFile) {
            $created->addMedia($photo->getRealPath())
                ->usingFileName($photo->getClientOriginalName())
                ->toMediaCollection('comment-photos', 'armpaudits');
        }

        return $created;
    }
}
