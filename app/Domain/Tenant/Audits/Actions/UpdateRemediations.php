<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Actions;

use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use App\Models\Remediation;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class UpdateRemediations
{
    /**
     * @param  array<int, array{comment?: string, completed?: bool, photo?: ?UploadedFile, remove_photo?: bool}>  $remediations
     */
    public function handle(ViolationAudit&Model $audit, User $user, array $remediations): void
    {
        $violations = $audit->violations()->with('remediation')->get();

        foreach ($violations as $violation) {
            $violationId = (int) $violation->getKey();
            $payload = $remediations[$violationId] ?? null;
            if ($payload === null) {
                continue;
            }

            $comment = (string) ($payload['comment'] ?? '');
            $completed = (bool) ($payload['completed'] ?? false);
            $newPhoto = $payload['photo'] ?? null;
            $removePhoto = (bool) ($payload['remove_photo'] ?? false);

            $remediation = $violation->remediation ?? new Remediation(['violation_id' => $violationId]);
            $isNew = ! $remediation->exists;

            if ($removePhoto && ! $isNew) {
                $remediation->getFirstMedia('remediations')?->delete();
            }

            $remediation->comment = $comment;
            $remediation->completed = $completed;

            $hasPhoto = false;
            if ($newPhoto instanceof UploadedFile) {
                if ($isNew) {
                    $remediation->user_id = $user->id;
                    $remediation->save();
                    $isNew = false;
                }
                $remediation->addMedia($newPhoto->getRealPath())
                    ->usingFileName($newPhoto->getClientOriginalName())
                    ->toMediaCollection('remediations', 'armpaudits');
                $hasPhoto = true;
            }

            if (! $isNew) {
                $hasPhoto = $hasPhoto || $remediation->getMedia('remediations')->isNotEmpty();
            }

            $hasContent = ($comment !== '') || $completed || $hasPhoto;

            if ($isNew) {
                if ($hasContent) {
                    $remediation->user_id = $user->id;
                    $remediation->save();
                }

                continue;
            }

            if ($hasContent) {
                $remediation->user_id = $user->id;
                $remediation->save();
            } else {
                $remediation->delete();
            }
        }
    }
}
