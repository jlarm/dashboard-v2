<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class Index extends Component
{
    public Store $store;
    protected $listeners = [
        'refreshAudits' => '$refresh',
    ];

    public function render()
    {
        $query = FinanceAudit::where('store_id', $this->store->id)->orderBy('created_at', 'desc');

        if (auth()->user()->hasRole('Manager')) {
            $query->whereNot('pdf_path', null);
        }

        return view('livewire.dealer.store.single-store.audit.finance.index', [
            'financeAudits' => $query->get(),
        ])->layout('components.dealer-app');
    }
}
