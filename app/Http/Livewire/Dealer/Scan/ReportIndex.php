<?php

namespace App\Http\Livewire\Dealer\Scan;

use App\Models\Dealer\ScanReport;
use App\Models\Dealer\Store;
use Livewire\Component;

class ReportIndex extends Component
{
    public Store $store;

    protected function formattedlastScanDate($date): string
    {
        return date('F d, Y', strtotime($date));
    }

    protected function fetchReports()
    {
        $query = ScanReport::where('scan_type', 'external')->latest();

        if (tenant('locations')) {
            $query->where('store_id', $this->store->id);
        }

        return $query->get();
    }

    protected function groupAndMapReports($reports)
    {
        return $reports->groupBy(function ($data) {
            return $this->formattedlastScanDate($data->last_scan);
        })->map(function ($data) {
            return $data->groupBy('type');
        })->map(function ($data) {
            return $data->map(function ($data) {
                return $data->first();
            });
        });
    }

    public function render()
    {
        $reports = $this->fetchReports();
        $groupedReports = $this->groupAndMapReports($reports);

        return view('livewire.dealer.scan.report-index', [
            'reports' => $groupedReports,
        ]);
    }
}
