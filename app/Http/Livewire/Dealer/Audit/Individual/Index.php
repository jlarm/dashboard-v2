<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public Store $store;
    protected $listeners = [
        'refreshIndividualAudits' => '$refresh',
    ];

    public function render(): View
    {
        return view('livewire.dealer.audit.individual.index', [
            'audits' => IndividualAudit::query()
                ->orderBy('audit_date', 'desc')
                ->where('parent_id', null)
                ->with('store')
                ->where('store_id', $this->store->id)
                ->get(),
        ]);
    }
}
