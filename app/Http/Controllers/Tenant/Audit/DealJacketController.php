<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Audit;

use App\Domain\Tenant\DealJackets\Actions\CompleteDealJacketGroup;
use App\Domain\Tenant\DealJackets\Actions\CreateOrFindCurrentQuarterGroup;
use App\Domain\Tenant\DealJackets\Actions\DeleteDealJacket;
use App\Domain\Tenant\DealJackets\Actions\DeleteDealJacketGroup;
use App\Domain\Tenant\DealJackets\Actions\SaveDealJacket;
use App\Domain\Tenant\DealJackets\Data\DealJacketDetail;
use App\Domain\Tenant\DealJackets\Data\DealJacketGroupListItem;
use App\Domain\Tenant\DealJackets\Queries\BuildDealJacketCharts;
use App\Domain\Tenant\DealJackets\Queries\ListDealJacketGroups;
use App\Domain\Tenant\DealJackets\Queries\ListDealJacketManagers;
use App\Domain\Tenant\DealJackets\Queries\ListDealJacketQuestions;
use App\Domain\Tenant\DealJackets\Queries\LoadDealJacketGroup;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\DealJackets\SaveDealJacketRequest;
use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use RuntimeException;

class DealJacketController extends Controller
{
    public function index(
        Request $request,
        ListDealJacketGroups $listGroups,
        BuildDealJacketCharts $buildCharts,
    ): InertiaResponse {
        $user = $request->user();
        throw_unless($user instanceof User, RuntimeException::class, 'Authenticated user required.');

        $store = $this->resolveStore($request);

        return Inertia::render('tenant/audits/deal-jackets/Index', [
            'store' => ['id' => $store->id, 'name' => $store->name],
            'groups' => $listGroups->handle($store->id, $user)
                ->map(static fn (DealJacketGroupListItem $item): array => $item->toArray())
                ->all(),
            'charts' => $buildCharts->handle($store->id),
            'flash_group_uuid' => session('dealJacketGroupUuid'),
        ]);
    }

    public function startGroup(
        Request $request,
        CreateOrFindCurrentQuarterGroup $createOrFind,
    ): RedirectResponse {
        $store = $this->resolveStore($request);
        $this->authorize('create', DealJacketGroup::class);

        [$group, $existed] = $createOrFind->handle($store->id);

        if ($existed) {
            return to_route('dealer.audit.deal-jackets.index')
                ->with('message', 'Deal Jacket audits have already been started for this quarter.')
                ->with('dealJacketGroupUuid', $group->uuid);
        }

        return to_route('dealer.audit.deal-jackets.show', $group->uuid);
    }

    public function show(string $dealJacketGroup, LoadDealJacketGroup $loadGroup): InertiaResponse
    {
        $group = $this->findGroup($dealJacketGroup);

        return Inertia::render('tenant/audits/deal-jackets/GroupShow', [
            'group' => $loadGroup->handle($group),
        ]);
    }

    public function complete(
        string $dealJacketGroup,
        CompleteDealJacketGroup $complete,
    ): RedirectResponse {
        $group = $this->findGroup($dealJacketGroup);
        $this->authorize('update', $group);

        $complete->handle($group);

        return back()->with('success', 'Deal Jacket group marked complete.');
    }

    public function destroyGroup(
        string $dealJacketGroup,
        DeleteDealJacketGroup $delete,
    ): RedirectResponse {
        $group = $this->findGroup($dealJacketGroup);
        $this->authorize('delete', $group);

        $delete->handle($group);

        return to_route('dealer.audit.deal-jackets.index')
            ->with('success', 'Deal Jacket group deleted.');
    }

    public function create(
        string $dealJacketGroup,
        ListDealJacketQuestions $listQuestions,
        ListDealJacketManagers $listManagers,
        Request $request,
    ): InertiaResponse {
        $group = $this->findGroup($dealJacketGroup);
        $this->authorize('create', DealJacket::class);

        $store = $this->resolveStore($request);

        return Inertia::render('tenant/audits/deal-jackets/Form', [
            'group' => ['id' => $group->id, 'uuid' => $group->uuid],
            'jacket' => null,
            'questions' => $listQuestions->handle(),
            'managers' => $listManagers->handle($store->id),
        ]);
    }

    public function edit(
        string $dealJacketGroup,
        string $dealJacket,
        ListDealJacketQuestions $listQuestions,
        ListDealJacketManagers $listManagers,
        Request $request,
    ): InertiaResponse {
        $group = $this->findGroup($dealJacketGroup);
        $jacket = $this->findJacket($group, $dealJacket);
        $this->authorize('update', $jacket);

        $store = $this->resolveStore($request);

        return Inertia::render('tenant/audits/deal-jackets/Form', [
            'group' => ['id' => $group->id, 'uuid' => $group->uuid],
            'jacket' => DealJacketDetail::fromModel($jacket)->toArray(),
            'questions' => $listQuestions->handle(),
            'managers' => $listManagers->handle($store->id),
        ]);
    }

    public function store(
        string $dealJacketGroup,
        SaveDealJacketRequest $request,
        SaveDealJacket $save,
    ): RedirectResponse {
        $group = $this->findGroup($dealJacketGroup);
        $this->authorize('create', DealJacket::class);

        $save->handle($group, null, $request->toData());

        return to_route('dealer.audit.deal-jackets.show', $group->uuid)
            ->with('success', 'Deal Jacket audit created.');
    }

    public function update(
        string $dealJacketGroup,
        string $dealJacket,
        SaveDealJacketRequest $request,
        SaveDealJacket $save,
    ): RedirectResponse {
        $group = $this->findGroup($dealJacketGroup);
        $jacket = $this->findJacket($group, $dealJacket);
        $this->authorize('update', $jacket);

        $save->handle($group, $jacket, $request->toData());

        return to_route('dealer.audit.deal-jackets.show', $group->uuid)
            ->with('success', 'Deal Jacket audit updated.');
    }

    public function destroy(
        string $dealJacketGroup,
        string $dealJacket,
        DeleteDealJacket $delete,
    ): RedirectResponse {
        $group = $this->findGroup($dealJacketGroup);
        $jacket = $this->findJacket($group, $dealJacket);
        $this->authorize('delete', $jacket);

        $delete->handle($jacket);

        return back()->with('success', 'Deal Jacket deleted.');
    }

    private function findGroup(string $uuid): DealJacketGroup
    {
        return DealJacketGroup::query()->where('uuid', $uuid)->firstOrFail();
    }

    private function findJacket(DealJacketGroup $group, string $uuid): DealJacket
    {
        return DealJacket::query()
            ->where('deal_jacket_group_id', $group->id)
            ->where('uuid', $uuid)
            ->firstOrFail();
    }

    private function resolveStore(Request $request): Store
    {
        if (app()->bound('currentStoreModel')) {
            $candidate = resolve('currentStoreModel');
            if ($candidate instanceof Store) {
                return $candidate;
            }
        }

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
