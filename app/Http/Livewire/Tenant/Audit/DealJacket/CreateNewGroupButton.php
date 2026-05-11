<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket;

use App\Http\Livewire\Concerns\ResolvesDashboardStore;
use App\Models\Dealer\Audit\DealJacketGroup;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class CreateNewGroupButton extends Component
{
    use AuthorizesRequests;
    use ResolvesDashboardStore;

    public function create(): RedirectResponse|Redirector
    {
        $storeId = $this->resolveDashboardStoreId();

        if (! is_int($storeId)) {
            return to_route('dealer.dashboard');
        }

        $this->authorize('create', DealJacketGroup::class);

        $existingGroup = $this->findExistingQuarterlyAudit($storeId);

        if ($existingGroup instanceof DealJacketGroup) {
            return $this->redirectToExistingGroup($existingGroup);
        }

        $dealJacketGroup = $this->createDealJacketGroup($storeId);

        return $this->redirectToNewGroup($dealJacketGroup);
    }

    public function render(): View
    {
        return view('livewire.tenant.audit.deal-jacket.create-new-group-button', [
            'hasStore' => is_int($this->resolveDashboardStoreId()),
        ]);
    }

    private function findExistingQuarterlyAudit(int $storeId): ?DealJacketGroup
    {
        $now = Date::now();

        return DealJacketGroup::query()
            ->where('store_id', $storeId)
            ->whereBetween('created_at', [$now->copy()->startOfQuarter(), $now->copy()->endOfQuarter()])
            ->first();
    }

    private function createDealJacketGroup(int $storeId): DealJacketGroup
    {
        return DealJacketGroup::query()->create([
            'store_id' => $storeId,
        ]);
    }

    private function redirectToExistingGroup(DealJacketGroup $existingGroup): RedirectResponse|Redirector
    {
        session()->flash('message', 'Deal Jacket audits have already been started for this quarter.');
        session()->flash('dealJacketGroupUuid', $existingGroup->uuid);

        return to_route('dealer.audit.deal-jackets.index');
    }

    private function redirectToNewGroup(DealJacketGroup $dealJacketGroup): RedirectResponse|Redirector
    {
        return to_route('dealer.audit.deal-jackets.show', $dealJacketGroup);
    }
}
