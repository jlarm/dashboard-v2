<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket;

use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Redirector;

class CreateNewGroupButton extends Component
{
    use AuthorizesRequests;

    public ?int $storeId = null;

    public function mount(): void
    {
        $this->storeId = $this->resolveStoreId();
    }

    public function create(): RedirectResponse|Redirector
    {
        if (! is_int($this->storeId)) {
            return $this->redirectRoute('dealer.dashboard');
        }

        $this->authorize('create', DealJacketGroup::class);

        $existingGroup = $this->findExistingQuarterlyAudit();

        if ($existingGroup instanceof DealJacketGroup) {
            return $this->redirectToExistingGroup($existingGroup);
        }

        $dealJacketGroup = $this->createDealJacketGroup();

        return $this->redirectToNewGroup($dealJacketGroup);
    }

    public function render(): View
    {
        return view('livewire.tenant.audit.deal-jacket.create-new-group-button');
    }

    private function findExistingQuarterlyAudit(): ?DealJacketGroup
    {
        if (! is_int($this->storeId)) {
            return null;
        }

        $now = Carbon::now();
        $quarterStart = $now->copy()->startOfQuarter();
        $quarterEnd = $now->copy()->endOfQuarter();

        return DealJacketGroup::query()
            ->where('store_id', $this->storeId)
            ->whereBetween('created_at', [$quarterStart, $quarterEnd])
            ->first();
    }

    private function createDealJacketGroup(): DealJacketGroup
    {
        return DealJacketGroup::query()->create([
            'store_id' => $this->storeId,
        ]);
    }

    private function redirectToExistingGroup(DealJacketGroup $existingGroup): RedirectResponse|Redirector
    {
        session()->flash('message', 'Deal Jacket audits have already been started for this quarter.');
        session()->flash('dealJacketGroupUuid', $existingGroup->uuid);

        return $this->redirectRoute('dealer.audit.deal-jackets.index');
    }

    private function redirectToNewGroup(DealJacketGroup $dealJacketGroup): RedirectResponse|Redirector
    {
        return $this->redirectRoute('dealer.audit.deal-jackets.show', $dealJacketGroup);
    }

    private function resolveStoreId(): ?int
    {
        $currentStore = app()->bound('currentStore') ? app('currentStore') : null;

        if (is_numeric($currentStore)) {
            return (int) $currentStore;
        }

        $scopedStoreIds = app()->bound('scopedStoreIds') ? app('scopedStoreIds') : collect();
        $firstScopedStoreId = $scopedStoreIds->first();

        if (is_numeric($firstScopedStoreId)) {
            return (int) $firstScopedStoreId;
        }

        $fallbackStoreId = Store::query()->orderBy('id')->value('id');

        return is_numeric($fallbackStoreId) ? (int) $fallbackStoreId : null;
    }
}
