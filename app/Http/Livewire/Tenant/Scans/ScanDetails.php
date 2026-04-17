<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Scans;

use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Illuminate\View\View;
use Livewire\Component;

class ScanDetails extends Component
{
    public bool $loaded = false;
    protected ?Store $store = null;
    protected ?CyrismaService $cyrisma = null;

    public function loadScanData(): void
    {
        $this->store = Store::query()->find(resolve('currentStore'));
        $this->cyrisma = resolve(CyrismaService::class)->forStore($this->store);
        $this->loaded = true;
    }

    public function render(): View
    {
        return view('livewire.tenant.scans.scan-details', [
            'cyrisma' => $this->cyrisma,
        ]);
    }
}
