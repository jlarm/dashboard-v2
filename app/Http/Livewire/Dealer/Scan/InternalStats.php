<?php

namespace App\Http\Livewire\Dealer\Scan;

use App\Models\Dealer\ScanReport;
use Livewire\Component;

class InternalStats extends Component
{
    public function render()
    {
        return view('livewire.dealer.scan.internal-stats', [
            'stats' => ScanReport::query()
                ->where('scan_type', '=', 'internal')
                ->latest()
                ->select('grade', 'exploits_high', 'exploits_medium', 'exploits_low', 'cves_high', 'cves_medium', 'cves_low')
                ->first(),
        ]);
    }
}
