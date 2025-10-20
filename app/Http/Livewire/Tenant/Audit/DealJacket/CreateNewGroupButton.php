<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket;

use App\Models\Dealer\Audit\DealJacketGroup;
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

        if ($existingGroup = $this->checkAudit()) {
            session()->flash('message', 'Deal Jacket audits have already been started for this quarter.');
            session()->flash('dealJacketGroupUuid', $existingGroup->uuid);

            return redirect()->route('dealer.audit.deal-jackets.index');
        }

        $dealJacketGroup = DealJacketGroup::create([
            'store_id' => $this->storeId,
        ]);

        return redirect()->route('dealer.audit.deal-jackets.show', $dealJacketGroup);
    }

    public function render(): View
    {
        return view('livewire.tenant.audit.deal-jacket.create-new-group-button');
    }

    private function checkAudit(): ?DealJacketGroup
    {
        $now = Carbon::now();
        $quarterStart = $now->copy()->startOfQuarter();
        $quarterEnd = $now->copy()->endOfQuarter();

        return DealJacketGroup::query()
            ->where('store_id', $this->storeId)
            ->whereBetween('created_at', [$quarterStart, $quarterEnd])
            ->first();
    }
}
