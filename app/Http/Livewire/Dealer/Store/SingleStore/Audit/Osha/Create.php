<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\Osha;

use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class Create extends Component
{
    public Store $store;

    public function mount()
    {
        $audit = OshaAudit::create([
            'user_id' => auth()->id(),
            'store_id' => $this->store->id ?? Store::first()->id,
            'audit_date' => now()->format('Y-m-d'),
        ]);

        return redirect()->to(route('dealer.stores.audits.osha.show', [$this->store, $audit->id]));
    }
}
