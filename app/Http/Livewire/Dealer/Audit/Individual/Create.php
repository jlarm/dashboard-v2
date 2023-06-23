<?php

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public Store $store;
    public IndividualAudit $individualAudit;
    public function mount()
    {
        $audit = IndividualAudit::create([
            'user_id' => auth()->id(),
            'parent_id' => $this->individualAudit->id ?? null,
            'deal_jacket_date' => now()->format('Y-m-d'),
            'uuid' => Str::uuid(),
            'store_id' => $this->store->id ?? Store::first()->id,
            'audit_date' => now()->format('Y-m-d'),
        ]);

        return redirect()->to(route('dealer.audit.individual.edit', [$this->store, $audit->uuid]));
    }
}
