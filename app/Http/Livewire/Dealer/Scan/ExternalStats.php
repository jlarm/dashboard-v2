<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Scan;

use App\Models\Dealer\ScanReport;
use App\Models\Dealer\Store;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ExternalStats extends Component
{
    public Store $store;

    public function render(): Factory|View
    {
        return view('livewire.dealer.scan.external-stats', [
            'stats' => ScanReport::query()
                ->where('store_id', $this->store->id ?? Store::query()->first()->id)
                ->where('scan_type', '=', 'external')
                ->latest()
                ->select('grade', 'exploits_high', 'exploits_medium', 'exploits_low', 'cves_high', 'cves_medium', 'cves_low')
                ->first(),
        ]);
    }
}
