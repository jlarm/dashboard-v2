<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Scans;

use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public bool $loaded = false;
    public bool $isConfigured = false;
    public bool $hasShortName = false;
    public bool $hasExternalScans = false;
    public bool $hasInternalScans = false;
    protected ?Store $store = null;
    protected ?CyrismaService $cyrisma = null;
    protected $listeners = ['refreshCache'];

    public function loadScanData(): void
    {
        $this->store = Store::find(app('currentStore'));
        $this->cyrisma = app(CyrismaService::class)->forStore($this->store);
        $this->isConfigured = $this->cyrisma->isConfigured();
        $this->hasShortName = $this->cyrisma->hasShortName();

        if ($this->isConfigured && $this->hasShortName) {
            $this->hasExternalScans = $this->cyrisma->getExternalIpScanData() !== null;
            $this->hasInternalScans = $this->cyrisma->hasInternalScans();
        }

        $this->loaded = true;
    }

    public function refreshCache(): void
    {
        $store = Store::find(app('currentStore'));
        app(CyrismaService::class)->forStore($store)->clearCache();

        $this->dispatchBrowserEvent('refresh-page');
    }

    public function render(): View
    {
        return view('livewire.tenant.scans.index', [
            'cyrisma' => $this->cyrisma,
        ])->layout('components.dealer-app');
    }
}
