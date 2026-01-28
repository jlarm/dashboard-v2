<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\Individual;

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
            'parent_id' => $this->individualAudit->id ?? null,
            'deal_jacket_date' => now()->format('Y-m-d'),
            'uuid' => (string) Str::uuid(),
            'user_id' => auth()->id(),
            'store_id' => $this->store->id,
            'audit_date' => now()->format('Y-m-d'),
        ]);

        return redirect()->to(route('dealer.stores.audits.individual.edit', [$this->store, $audit->uuid]));
    }
}
