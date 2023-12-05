<?php

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Illuminate\Http\Request;
use Livewire\Component;

class Index extends Component
{
    public Store $store;
    public $currentStore;

    public function mount(Request $request): void
    {
        $this->currentStore = Store::where('name', $request->get('store')?->name)->first();
    }

    protected $listeners = [
        'refreshIndividualAudits' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.dealer.audit.individual.index', [
            'audits' => IndividualAudit::orderBy('audit_date', 'desc')
                ->latest()->where('parent_id', null)
                ->with('store')
                ->where('store_id', $this->store->id)
                ->get()
        ]);
    }
}
