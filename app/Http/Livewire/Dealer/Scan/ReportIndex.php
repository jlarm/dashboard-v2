<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Scan;

use App\Models\Dealer\ScanReport;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class ReportIndex extends Component
{
    public Store $store;

    public function render(): View
    {
        $reports = $this->fetchReports();
        $groupedReports = $this->groupAndMapReports($reports);

        return view('livewire.dealer.scan.report-index', [
            'reports' => $groupedReports,
        ]);
    }

    protected function formattedLastScanDate($date): string
    {
        return $date->format('F d, Y');
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
        return $reports->groupBy(fn ($data) => $this->formattedLastScanDate($data->created_at))->map(fn ($data) => $data->groupBy('type'))->map(fn ($data) => $data->map(fn ($data) => $data->first()));
    }
}
