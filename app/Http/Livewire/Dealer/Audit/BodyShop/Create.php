<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class Create extends Component
{
    public Store $store;

    public function mount()
    {
        $audit = BodyShopAudit::query()->create([
            'user_id' => auth()->id(),
            'store_id' => $this->store->id ?? Store::query()->first()->id,
            'audit_date' => now()->format('Y-m-d'),
        ]);

        return redirect()->to(route('dealer.audit.body-shop.show', $audit));
    }
}
