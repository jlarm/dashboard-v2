<?php

namespace App\Http\Livewire\Dealer\Scan;

use App\Models\Dealer\ScanReport;
use App\Models\Dealer\Store;
use Livewire\Component;

class InternalReportIndex extends Component
{
    public Store $store;

    protected function formattedLastScanDate($date): string
    {
        return date('F d, Y', strtotime($date));
    }

    public function render()
    {
        if (tenant('locations')) {
            return view('livewire.dealer.scan.internal-report-index', [
                'reports' => ScanReport::where('scan_type', 'internal')
                    ->where('store_id', $this->store->id)
                    ->latest()
                    ->get()
                    ->groupBy(function ($data) {
                        return $this->formattedLastScanDate($data->created_at);
                    })->map(function ($data) {
                        return $data->groupBy('type');
                    })->map(function ($data) {
                        return $data->map(function ($data) {
                            return $data->first();
                        });
                    }),
            ]);
        } else {
            return view('livewire.dealer.scan.internal-report-index', [
                'reports' => ScanReport::where('scan_type', 'internal')
                    ->latest()
                    ->get()
                    ->groupBy(function ($data) {
                        return $this->formattedLastScanDate($data->created_at);
                    })->map(function ($data) {
                        return $data->groupBy('type');
                    })->map(function ($data) {
                        return $data->map(function ($data) {
                            return $data->first();
                        });
                    }),
            ]);
        }
    }
}
