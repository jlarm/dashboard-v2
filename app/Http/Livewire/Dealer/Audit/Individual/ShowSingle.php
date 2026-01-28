<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class ShowSingle extends Component
{
    public IndividualAudit $audit;
    public Store $store;

    public function mount(IndividualAudit $audit): void
    {
        $this->audit = $audit->load('manager');
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.individual.show-single');
    }
}
