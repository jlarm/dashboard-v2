<?php

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class Index extends Component
{
    public Store $store;

    protected $listeners = [
        'refreshIndividualAudits' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.dealer.audit.individual.index', [
            'audits' => IndividualAudit::latest()->with('store')->select('id', 'store_id', 'draft', 'audit_date', 'pdf_path')->get()
        ]);
    }
}
