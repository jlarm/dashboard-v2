<?php

namespace App\Http\Livewire\Dealer\Settings;

use App\Models\Dealer\Store;
use Livewire\Component;

class ComplianceInfoDownloadView extends Component
{
    public Store $store;
    public function render()
    {
        return view('livewire.dealer.settings.compliance-info-download-view', [
            'managers' => $this->store->employeeList,
        ]);
    }
}
