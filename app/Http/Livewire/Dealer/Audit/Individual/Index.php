<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;
use Override;

class Index extends Component
{
    public Store $store;

    #[Override]
    protected $listeners = [
        'refreshIndividualAudits' => '$refresh',
    ];

    public function render(): View
    {
        return view('livewire.dealer.audit.individual.index', [
            'audits' => IndividualAudit::query()
                ->latest('audit_date')
                ->where('parent_id')
                ->with('store')
                ->where('store_id', $this->store->id)
                ->get(),
        ]);
    }
}
