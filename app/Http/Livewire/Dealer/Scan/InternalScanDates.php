<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Scan;

use App\Models\Dealer\ScanReport;
use Livewire\Component;

class InternalScanDates extends Component
{
    public function render()
    {
        return view('livewire.dealer.scan.internal-scan-dates', [
            'scanDates' => ScanReport::query()
                ->where('scan_type', '=', 'internal')
                ->latest()
                ->select('last_scan', 'next_scan')
                ->first(),
        ]);
    }
}
