<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Audit;

use App\Domain\Tenant\IndividualAudits\Actions\CreateIndividualAudit;
use App\Domain\Tenant\IndividualAudits\Actions\DeleteIndividualAudit;
use App\Domain\Tenant\IndividualAudits\Actions\DispatchIndividualAuditPdfGeneration;
use App\Domain\Tenant\IndividualAudits\Actions\UpdateIndividualAudit;
use App\Domain\Tenant\IndividualAudits\Queries\ListIndividualAudits;
use App\Domain\Tenant\IndividualAudits\Queries\ListIndividualQuestions;
use App\Domain\Tenant\IndividualAudits\Queries\ListManagers;
use App\Domain\Tenant\IndividualAudits\Queries\LoadIndividualAuditDetail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\IndividualAudits\UpdateIndividualAuditRequest;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use RuntimeException;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

class IndividualAuditController extends Controller
{
    public function index(Request $request, ListIndividualAudits $listAudits): InertiaResponse
    {
        $store = $this->resolveStore($request);

        return Inertia::render('tenant/audits/individual/Index', [
            'store' => ['id' => $store->id, 'name' => $store->name],
            'audits' => $listAudits->handle($store->id)
                ->map(static fn ($item): array => $item->toArray())
                ->all(),
        ]);
    }

    public function show(string $individualAudit, LoadIndividualAuditDetail $loadDetail): InertiaResponse
    {
        $audit = $this->findByUuid($individualAudit);

        return Inertia::render('tenant/audits/individual/Show', [
            'audit' => $loadDetail->handle($audit)->toArray(),
        ]);
    }

    public function create(
        Request $request,
        ?string $individualAudit,
        CreateIndividualAudit $createAudit,
    ): RedirectResponse {
        $user = $request->user();
        throw_unless($user instanceof User, RuntimeException::class, 'Authenticated user required.');

        $store = $this->resolveStore($request);
        $parent = $individualAudit !== null ? $this->findByUuidOrId($individualAudit) : null;

        $audit = $createAudit->handle($user, $store, $parent);

        return to_route('dealer.audit.individual.edit', $audit->uuid);
    }

    public function edit(
        string $individualAudit,
        LoadIndividualAuditDetail $loadDetail,
        ListIndividualQuestions $listQuestions,
        ListManagers $listManagers,
    ): InertiaResponse {
        $audit = $this->findByUuid($individualAudit);

        return Inertia::render('tenant/audits/individual/Edit', [
            'audit' => $loadDetail->handle($audit)->toArray(),
            'questions' => $listQuestions->handle(),
            'managers' => $listManagers->handle(),
        ]);
    }

    public function update(
        string $individualAudit,
        UpdateIndividualAuditRequest $request,
        UpdateIndividualAudit $updateAudit,
    ): RedirectResponse {
        $audit = $this->findByUuid($individualAudit);

        $updateAudit->handle($audit, $request->toData());

        if ($request->boolean('exit')) {
            $parent = $audit->parent_id !== null
                ? IndividualAudit::query()->whereKey($audit->parent_id)->firstOrFail()
                : $audit;

            return to_route('dealer.audit.individual.show', $parent->uuid)
                ->with('success', 'Deal jacket audit updated.');
        }

        return back()->with('success', 'Deal jacket audit updated.');
    }

    public function destroy(string $individualAudit, DeleteIndividualAudit $deleteAudit): RedirectResponse
    {
        $audit = $this->findByUuid($individualAudit);

        $parentUuid = $audit->parent_id !== null
            ? IndividualAudit::query()->whereKey($audit->parent_id)->value('uuid')
            : null;

        $deleteAudit->handle($audit);

        if (is_string($parentUuid)) {
            return to_route('dealer.audit.individual.show', $parentUuid)
                ->with('success', 'Deal jacket deleted.');
        }

        return to_route('dealer.audit.individual.index')
            ->with('success', 'Deal jacket audit deleted.');
    }

    public function generate(
        string $individualAudit,
        DispatchIndividualAuditPdfGeneration $dispatch,
    ): RedirectResponse {
        $audit = $this->findByUuid($individualAudit);

        $dispatch->handle($audit);

        return back()->with('success', 'Report is being generated. It will appear when ready.');
    }

    public function download(string $individualAudit): SymfonyRedirectResponse|RedirectResponse
    {
        $audit = $this->findByUuid($individualAudit);

        abort_unless(is_string($audit->pdf_path) && $audit->pdf_path !== '', 404);

        $url = Storage::disk('do-audits')->url(tenant('id').'/individual-audits/'.$audit->pdf_path);

        return redirect()->away($url);
    }

    private function findByUuid(string $uuid): IndividualAudit
    {
        return IndividualAudit::query()->where('uuid', $uuid)->firstOrFail();
    }

    private function findByUuidOrId(string $key): IndividualAudit
    {
        if (ctype_digit($key)) {
            return IndividualAudit::query()->whereKey((int) $key)->firstOrFail();
        }

        return $this->findByUuid($key);
    }

    private function resolveStore(Request $request): Store
    {
        $user = $request->user();
        if ($user instanceof User && $user->current_store_id !== null) {
            $store = Store::query()->whereKey($user->current_store_id)->first();
            if ($store instanceof Store) {
                return $store;
            }
        }

        $store = Store::query()->orderBy('id')->first();
        abort_unless($store instanceof Store, 404);

        return $store;
    }
}
