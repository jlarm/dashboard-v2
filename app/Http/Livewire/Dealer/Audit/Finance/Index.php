<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class Index extends Component
{
    public Store $store;

    protected $listeners = [
        'refreshFinanceAudits' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.dealer.audit.finance.index', [
            'financeAudits' => FinanceAudit::latest()->with('store')->select('id', 'store_id', 'draft', 'audit_date', 'pdf_path')->get()
        ]);
    }
}
