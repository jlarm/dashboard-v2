<?php

namespace App\Http\Livewire\Tenant\Scans\Components;

use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Illuminate\View\View;
use Livewire\Component;

class OpenPorts extends Component
{
    public array $openPorts = [];

    public function mount(): void
    {
        $store = Store::find(app('currentStore'));

        if ($store) {
            $this->openPorts = app(CyrismaService::class)->forStore($store)->getOpenPorts() ?? [];
        }
    }
    public function render(): View
    {
        return view('livewire.tenant.scans.components.open-ports');
    }
}
