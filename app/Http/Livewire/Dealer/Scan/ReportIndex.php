<?php

namespace App\Http\Livewire\Dealer\Scan;

use App\Models\Dealer\ScanReport;
use Livewire\Component;

class ReportIndex extends Component
{
    public function render()
    {
        return view('livewire.dealer.scan.report-index', [
            'reports' => ScanReport::latest()->get()->groupBy(function($data) {
                return $data->created_at->format('F d, Y');
            }),
        ]);
    }
}
