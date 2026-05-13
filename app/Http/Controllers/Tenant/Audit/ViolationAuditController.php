<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Audit;

use App\Domain\Tenant\Audits\Actions\AddViolationFromStatement;
use App\Domain\Tenant\Audits\Actions\CreateAuditComment;
use App\Domain\Tenant\Audits\Actions\CreateViolationAudit;
use App\Domain\Tenant\Audits\Actions\DeleteAuditComment;
use App\Domain\Tenant\Audits\Actions\DeleteViolation;
use App\Domain\Tenant\Audits\Actions\DeleteViolationAudit;
use App\Domain\Tenant\Audits\Actions\DeleteViolationPhoto;
use App\Domain\Tenant\Audits\Actions\DispatchAuditPdfGeneration;
use App\Domain\Tenant\Audits\Actions\DispatchRemediationPdfGeneration;
use App\Domain\Tenant\Audits\Actions\StreamAuditPdf;
use App\Domain\Tenant\Audits\Actions\ToggleAuditCompletion;
use App\Domain\Tenant\Audits\Actions\UpdateAuditComment;
use App\Domain\Tenant\Audits\Actions\UpdateAuditGrade;
use App\Domain\Tenant\Audits\Actions\UpdateRemediations;
use App\Domain\Tenant\Audits\Actions\UpdateViolationAudit;
use App\Domain\Tenant\Audits\Queries\BuildAuditChartData;
use App\Domain\Tenant\Audits\Queries\ListLegacyAudits;
use App\Domain\Tenant\Audits\Queries\ListViolationAudits;
use App\Domain\Tenant\Audits\Queries\LoadViolationAuditWithRelations;
use App\Domain\Tenant\Audits\Queries\SearchViolationStatements;
use App\Enums\ViolationAuditType;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tenant\Audit\Concerns\ResolvesAuditScope;
use App\Http\Requests\Tenant\Audits\AddViolationRequest;
use App\Http\Requests\Tenant\Audits\StoreAuditCommentRequest;
use App\Http\Requests\Tenant\Audits\UpdateAuditCommentRequest;
use App\Http\Requests\Tenant\Audits\UpdateAuditGradeRequest;
use App\Http\Requests\Tenant\Audits\UpdateRemediationsRequest;
use App\Http\Requests\Tenant\Audits\UpdateViolationAuditRequest;
use App\Http\Resources\Tenant\Audits\ViolationAuditListItemResource;
use App\Models\AuditComment;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use App\Models\Dealer\Violation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use RuntimeException;
use Spatie\LaravelPdf\PdfBuilder;

class ViolationAuditController extends Controller
{
    use ResolvesAuditScope;

    public function index(
        Request $request,
        ViolationAuditType $type,
        ListViolationAudits $listAudits,
        ListLegacyAudits $listLegacy,
        BuildAuditChartData $buildChart,
    ): InertiaResponse {
        $storeIds = $this->scopedStoreIds();
        $store = $this->resolveCurrentStore();

        $user = $request->user();
        $canSeeIncomplete = $user instanceof User && $user->hasAnyRole(['super-admin', 'Consultant']);

        $audits = $listAudits->handle($type, $storeIds, includeIncomplete: $canSeeIncomplete);
        $legacyData = $listLegacy->handle($type, $storeIds);
        $legacyRaw = $listLegacy->raw($type, $storeIds);

        $modelClass = $type->modelClass();
        $violationAuditsForChart = $storeIds->isEmpty()
            ? collect()
            : $modelClass::query()
                ->whereIn('store_id', $storeIds->all())
                ->unless($canSeeIncomplete, fn ($query) => $query->whereNotNull('completed_date'))
                ->withCount([
                    'violations as violation_count',
                    'violations as remediation_count' => fn ($q) => $q->whereHas('remediation', fn ($q) => $q->where('completed', true)),
                ])
                ->latest('date')
                ->get();

        $chart = $buildChart->handle($violationAuditsForChart, $legacyRaw);

        return Inertia::render('tenant/audits/Index', [
            'type' => $type->slug(),
            'label' => $type->label(),
            'store' => $store instanceof Store
                ? ['id' => $store->id, 'name' => $store->name]
                : null,
            'audits' => ViolationAuditListItemResource::collection($audits),
            'legacy_audits' => $legacyData->map(static fn ($item): array => $item->toArray())->all(),
            'chart' => $chart,
        ]);
    }

    public function show(
        string $audit,
        Request $request,
        ViolationAuditType $type,
        LoadViolationAuditWithRelations $loadAudit,
    ): InertiaResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);
        $this->authorizeAuditVisibility($request, $model);

        $detail = $loadAudit->handle($model, withRemediation: true);

        return Inertia::render('tenant/audits/Show', [
            'type' => $type->slug(),
            'label' => $type->label(),
            'audit' => $detail->toArray(),
        ]);
    }

    public function edit(
        string $audit,
        ViolationAuditType $type,
        LoadViolationAuditWithRelations $loadAudit,
    ): InertiaResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);

        $detail = $loadAudit->handle($model, withRemediation: false);

        return Inertia::render('tenant/audits/Edit', [
            'type' => $type->slug(),
            'label' => $type->label(),
            'audit' => $detail->toArray(),
        ]);
    }

    public function update(
        string $audit,
        ViolationAuditType $type,
        UpdateViolationAuditRequest $request,
        UpdateViolationAudit $updateAudit,
    ): RedirectResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);

        $updateAudit->handle($model, $request->toData());

        return back()->with('success', 'Audit updated.');
    }

    public function destroy(
        string $audit,
        ViolationAuditType $type,
        DeleteViolationAudit $deleteAudit,
    ): RedirectResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);

        $deleteAudit->handle($model);

        return to_route('dealer.audit.'.$type->slug().'.index')
            ->with('success', $type->label().' audit deleted.');
    }

    public function create(
        Store $store,
        ViolationAuditType $type,
        Request $request,
        CreateViolationAudit $createAudit,
    ): RedirectResponse {
        $user = $request->user();
        throw_unless($user instanceof User, RuntimeException::class, 'Authenticated user required.');

        $audit = $createAudit->handle($type, $store, $user);

        return to_route('dealer.audit.'.$type->slug().'.edit', $audit->uuid);
    }

    public function remediation(
        string $audit,
        Request $request,
        ViolationAuditType $type,
        LoadViolationAuditWithRelations $loadAudit,
    ): InertiaResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);
        $this->authorizeAuditVisibility($request, $model);

        $detail = $loadAudit->handle($model, withRemediation: true);

        return Inertia::render('tenant/audits/Remediation', [
            'type' => $type->slug(),
            'label' => $type->label(),
            'audit' => $detail->toArray(),
        ]);
    }

    public function updateRemediation(
        string $audit,
        ViolationAuditType $type,
        UpdateRemediationsRequest $request,
        UpdateRemediations $updateRemediations,
    ): RedirectResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);

        $user = $request->user();
        throw_unless($user instanceof User, RuntimeException::class, 'Authenticated user required.');

        $updateRemediations->handle($model, $user, $request->toData());

        return back()->with('success', 'Remediation updated.');
    }

    public function addViolation(
        string $audit,
        ViolationAuditType $type,
        AddViolationRequest $request,
        AddViolationFromStatement $addViolation,
    ): RedirectResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);

        $addViolation->handle($model, $request->statementId());

        return back()->with('success', 'Violation added.');
    }

    public function deleteViolation(
        string $audit,
        Violation $violation,
        ViolationAuditType $type,
        DeleteViolation $deleteViolation,
    ): RedirectResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);

        abort_unless((int) $violation->violationable_id === (int) $model->getKey(), 404);

        $deleteViolation->handle($violation);

        return back()->with('success', 'Violation deleted.');
    }

    public function deleteViolationPhoto(
        string $audit,
        Violation $violation,
        int $photoId,
        ViolationAuditType $type,
        DeleteViolationPhoto $deletePhoto,
    ): RedirectResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);

        abort_unless((int) $violation->violationable_id === (int) $model->getKey(), 404);

        $deletePhoto->handle($violation, $photoId);

        return back()->with('success', 'Photo removed.');
    }

    public function searchStatements(
        string $audit,
        ViolationAuditType $type,
        Request $request,
        SearchViolationStatements $search,
    ) {
        $query = (string) $request->query('q', '');

        return response()->json(
            $search->handle($type, $query)
                ->map(static fn ($item): array => $item->toArray())
                ->all(),
        );
    }

    public function download(
        string $audit,
        Request $request,
        ViolationAuditType $type,
        StreamAuditPdf $streamPdf,
    ): PdfBuilder {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);
        $this->authorizeAuditVisibility($request, $model);

        return $streamPdf->handle($type, $model);
    }

    public function downloadRemediation(
        string $audit,
        Request $request,
        ViolationAuditType $type,
        StreamAuditPdf $streamPdf,
    ): PdfBuilder {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);
        $this->authorizeAuditVisibility($request, $model);

        return $streamPdf->handle($type, $model, remediation: true);
    }

    public function generate(
        string $audit,
        ViolationAuditType $type,
        DispatchAuditPdfGeneration $dispatch,
    ): RedirectResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);

        $dispatch->handle($type, $model);

        return back()->with('success', 'Audit PDF is being generated.');
    }

    public function generateRemediation(
        string $audit,
        ViolationAuditType $type,
        DispatchRemediationPdfGeneration $dispatch,
    ): RedirectResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);

        $dispatch->handle($type, $model);

        return back()->with('success', 'Remediation PDF is being generated.');
    }

    public function storeComment(
        string $audit,
        ViolationAuditType $type,
        StoreAuditCommentRequest $request,
        CreateAuditComment $createComment,
    ): RedirectResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);

        $user = $request->user();
        throw_unless($user instanceof User, RuntimeException::class, 'Authenticated user required.');

        $createComment->handle($model, $user, $request->commentBody(), $request->photo());

        return back()->with('success', 'Comment added.');
    }

    public function updateComment(
        string $audit,
        AuditComment $comment,
        ViolationAuditType $type,
        UpdateAuditCommentRequest $request,
        UpdateAuditComment $updateComment,
    ): RedirectResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);
        $this->authorizeCommentOwnership($request, $comment, $model);

        $updateComment->handle($comment, $request->commentBody(), $request->photo(), $request->removePhoto());

        return back()->with('success', 'Comment updated.');
    }

    public function destroyComment(
        string $audit,
        AuditComment $comment,
        ViolationAuditType $type,
        Request $request,
        DeleteAuditComment $deleteComment,
    ): RedirectResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);
        $this->authorizeCommentOwnership($request, $comment, $model);

        $deleteComment->handle($comment);

        return back()->with('success', 'Comment deleted.');
    }

    public function complete(
        string $audit,
        ViolationAuditType $type,
        ToggleAuditCompletion $toggle,
    ): RedirectResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);

        $toggle->complete($model);

        return back()->with('success', $type->label().' audit marked complete.');
    }

    public function reopen(
        string $audit,
        ViolationAuditType $type,
        ToggleAuditCompletion $toggle,
    ): RedirectResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);

        $toggle->reopen($model);

        return back()->with('success', $type->label().' audit reopened.');
    }

    public function updateGrade(
        string $audit,
        ViolationAuditType $type,
        UpdateAuditGradeRequest $request,
        UpdateAuditGrade $updateGrade,
    ): RedirectResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);

        abort_if($model->completed_date === null, 422, 'Mark the audit complete before assigning a grade.');

        $user = $request->user();
        throw_unless($user instanceof User, RuntimeException::class, 'Authenticated user required.');

        $updateGrade->handle($model, $user, $request->grade());

        return back()->with('success', 'Grade updated.');
    }

    private function findAudit(ViolationAuditType $type, string $uuid): OshaViolationAudit|BodyShopViolationAudit|GlbaViolationAudit
    {
        $modelClass = $type->modelClass();

        /** @var OshaViolationAudit|BodyShopViolationAudit|GlbaViolationAudit $model */
        $model = $modelClass::query()->where('uuid', $uuid)->firstOrFail();

        return $model;
    }

    private function authorizeCommentOwnership(Request $request, AuditComment $comment, OshaViolationAudit|BodyShopViolationAudit|GlbaViolationAudit $audit): void
    {
        abort_unless((int) $comment->auditable_id === (int) $audit->getKey(), 404);
        abort_unless((int) $comment->user_id === (int) $request->user()?->id, 403);
    }
}
