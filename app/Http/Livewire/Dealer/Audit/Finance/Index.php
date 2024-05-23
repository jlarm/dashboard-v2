<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Store;
use Livewire\Component;

class Index extends Component
{
    public $store;

    protected $listeners = [
        'refreshAudits' => '$refresh',
    ];

    public function mount()
    {
        $this->store = Store::with('glbaViolationAudits')->where('id', app('currentStore'))->firstOrFail();
    }

    public function render()
    {
        return view('livewire.dealer.audit.finance.index', [
            'financeAudits' => $this->store->financeAudits->sortByDesc('audit_date'),
            'audits' => $this->store->glbaViolationAudits->sortByDesc('date'),
        ])->layout('components.dealer-app');
    }
}
