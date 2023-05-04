<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = [
        'refreshAudits' => '$refresh',
    ];
    public function render()
    {
        return view('livewire.dealer.audit.finance.index', [
            'financeAudits' => FinanceAudit::latest()->select('id', 'draft', 'audit_date')->get()
        ]);
    }
}
