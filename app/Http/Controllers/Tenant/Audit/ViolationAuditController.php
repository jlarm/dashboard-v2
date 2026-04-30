<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Audit;

use App\Domain\Tenant\Audits\Actions\AddViolationFromStatement;
use App\Domain\Tenant\Audits\Actions\CreateViolationAudit;
use App\Domain\Tenant\Audits\Actions\DeleteViolation;
use App\Domain\Tenant\Audits\Actions\DeleteViolationAudit;
use App\Domain\Tenant\Audits\Actions\DeleteViolationPhoto;
use App\Domain\Tenant\Audits\Actions\DispatchAuditPdfGeneration;
use App\Domain\Tenant\Audits\Actions\DispatchRemediationPdfGeneration;
use App\Domain\Tenant\Audits\Actions\SignAuditDownloadUrl;
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
use App\Http\Requests\Tenant\Audits\UpdateAuditGradeRequest;
use App\Http\Requests\Tenant\Audits\UpdateRemediationsRequest;
use App\Http\Requests\Tenant\Audits\UpdateViolationAuditRequest;
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
use Symfony\Component\HttpFoundation\StreamedResponse;

class ViolationAuditController extends Controller
{
    use ResolvesAuditScope;

    public function index(
        ViolationAuditType $type,
        ListViolationAudits $listAudits,
        ListLegacyAudits $listLegacy,
        BuildAuditChartData $buildChart,
    ): InertiaResponse {
        $storeIds = $this->scopedStoreIds();
        $store = $this->resolveCurrentStore();

        $audits = $listAudits->handle($type, $storeIds);
        $legacyData = $listLegacy->handle($type, $storeIds);
        $legacyRaw = $listLegacy->raw($type, $storeIds);

        $modelClass = $type->modelClass();
        $violationAuditsForChart = $storeIds->isEmpty()
            ? collect()
            : $modelClass::query()
                ->whereIn('store_id', $storeIds->all())
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
            'audits' => $audits->map(static fn ($item): array => $item->toArray())->all(),
            'legacy_audits' => $legacyData->map(static fn ($item): array => $item->toArray())->all(),
            'chart' => $chart,
        ]);
    }

    public function show(
        string $audit,
        ViolationAuditType $type,
        LoadViolationAuditWithRelations $loadAudit,
    ): InertiaResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);

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
        ViolationAuditType $type,
        LoadViolationAuditWithRelations $loadAudit,
    ): InertiaResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);

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
                ->map(static fn ($item) => $item->toArray())
                ->all(),
        );
    }

    public function download(
        string $audit,
        ViolationAuditType $type,
        SignAuditDownloadUrl $signUrl,
    ): StreamedResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);

        return $signUrl->downloadAuditPdf($model);
    }

    public function downloadRemediation(
        string $audit,
        ViolationAuditType $type,
        SignAuditDownloadUrl $signUrl,
    ): StreamedResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);

        return $signUrl->downloadRemediationPdf($model);
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

    public function updateGrade(
        string $audit,
        ViolationAuditType $type,
        UpdateAuditGradeRequest $request,
        UpdateAuditGrade $updateGrade,
    ): RedirectResponse {
        $model = $this->findAudit($type, $audit);
        $this->authorizeAuditScope($model);

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
}
