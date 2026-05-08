<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Queries;

use App\Domain\Tenant\Audits\Data\AuditCommentData;
use App\Domain\Tenant\Audits\Data\ViolationAuditDetailData;
use App\Domain\Tenant\Audits\Data\ViolationData;
use App\Models\AuditComment;
use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use App\Models\Dealer\Violation;
use App\Models\ViolationStatement;
use Illuminate\Database\Eloquent\Model;

class LoadViolationAuditWithRelations
{
    public function handle(ViolationAudit&Model $audit, bool $withRemediation = false): ViolationAuditDetailData
    {
        $violationsQuery = $audit->violations()->with(['media']);
        if ($withRemediation) {
            $violationsQuery->with(['remediation', 'remediation.user', 'remediation.media']);
        }
        $violations = $violationsQuery->get();

        $statementIds = $violations->pluck('statement_id')->filter()->unique()->values();
        $referenceImages = $statementIds->isEmpty()
            ? []
            : tenancy()->central(fn () => ViolationStatement::query()
                ->whereIn('id', $statementIds)
                ->pluck('reference_image_url', 'id')
                ->toArray()
            );

        $violationsData = $violations
            ->map(fn (Violation $violation): ViolationData => ViolationData::fromModel($violation, $referenceImages)) // @phpstan-ignore argument.type
            ->values()
            ->all();

        $comments = $audit->auditComments()
            ->with('user:id,name')
            ->latest()
            ->get()
            ->map(fn (AuditComment $comment): AuditCommentData => AuditCommentData::fromModel($comment)) // @phpstan-ignore argument.type
            ->values()
            ->all();

        $audit->loadMissing('store:id,name');

        return ViolationAuditDetailData::fromModel($audit, $violationsData, $comments);
    }
}
