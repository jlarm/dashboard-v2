<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class Show extends Component
{
    public Store $store;
    public FinanceAudit $financeAudit;

    public function render()
    {
        return view('livewire.dealer.store.single-store.audit.finance.show')->layout('components.dealer-app');
    }
}
