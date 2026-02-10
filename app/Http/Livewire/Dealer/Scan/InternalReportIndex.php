<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Scan;

use Illuminate\Support\Carbon;
use App\Models\Dealer\ScanReport;
use App\Models\Dealer\Store;
use Livewire\Component;

class InternalReportIndex extends Component
{
    public Store $store;

    public function render()
    {
        if (tenant('locations')) {
            return view('livewire.dealer.scan.internal-report-index', [
                'reports' => ScanReport::query()->where('scan_type', 'internal')
                    ->where('store_id', $this->store->id)
                    ->latest()
                    ->get()
                    ->groupBy(fn ($data): string => $this->formattedLastScanDate($data->created_at))->map(fn ($data) => $data->groupBy('type'))->map(fn ($data) => $data->map(fn ($data) => $data->first())),
            ]);
        }

        return view('livewire.dealer.scan.internal-report-index', [
            'reports' => ScanReport::query()->where('scan_type', 'internal')
                ->latest()
                ->get()
                ->groupBy(fn ($data): string => $this->formattedLastScanDate($data->created_at))->map(fn ($data) => $data->groupBy('type'))->map(fn ($data) => $data->map(fn ($data) => $data->first())),
        ]);

    }

    protected function formattedLastScanDate(Carbon $date): string
    {
        return $date->format('F d, Y');
    }
}
