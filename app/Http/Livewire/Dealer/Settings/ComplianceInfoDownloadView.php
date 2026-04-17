<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Settings;

use App\Models\Dealer\Store;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ComplianceInfoDownloadView extends Component
{
    public Store $store;

    public function render(): Factory|View
    {
        return view('livewire.dealer.settings.compliance-info-download-view', [
            'managers' => $this->store->employeeList,
        ]);
    }
}
