<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Scan;

use App\Models\Dealer\ScanReport;
use App\Models\Dealer\Store;
use Livewire\Component;

class IndexList extends Component
{
    public Store $store;
    public function render()
    {
        return view('livewire.dealer.store.single-store.scan.index-list', [
            'reports' => ScanReport::where('store_id', $this->store->id)->latest()->get()->groupBy(function($data) {
                return $data->created_at->format('F d, Y');
            }),
        ]);
    }
}
