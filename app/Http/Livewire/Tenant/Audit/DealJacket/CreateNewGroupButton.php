<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket;

use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Redirector;

class CreateNewGroupButton extends Component
{
    use AuthorizesRequests;

    public int $storeId;

    public function mount(): void
    {
        $this->storeId = app('currentStore');
    }

    public function create(): Redirector
    {
        $this->authorize('create', DealJacketGroup::class);

        $existingGroup = $this->findExistingQuarterlyAudit();

        if ($existingGroup) {
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
        return DealJacketGroup::create([
            'store_id' => $this->storeId,
        ]);
    }

    private function redirectToExistingGroup(DealJacketGroup $existingGroup): Redirector
    {
        session()->flash('message', 'Deal Jacket audits have already been started for this quarter.');
        session()->flash('dealJacketGroupUuid', $existingGroup->uuid);

        if (tenant('locations')) {
            $store = Store::find($this->storeId);
            session()->flash('storeSlug', $store->slug);

            return redirect()->route('dealer.stores.audits.deal-jackets.index', [$store]);
        }

        return redirect()->route('dealer.audit.deal-jackets.index');
    }

    private function redirectToNewGroup(DealJacketGroup $dealJacketGroup): Redirector
    {
        if (tenant('locations')) {
            $store = Store::find($this->storeId);

            return redirect()->route('dealer.stores.audits.deal-jackets.show', [$store, $dealJacketGroup]);
        }

        return redirect()->route('dealer.audit.deal-jackets.show', $dealJacketGroup);
    }
}
