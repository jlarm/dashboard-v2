<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Scans;

use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public bool $loaded = false;
    public bool $isConfigured = false;
    public bool $hasShortName = false;
    public bool $hasExternalScans = false;
    public bool $hasInternalScans = false;
    public ?string $error = null;
    public int $storeId = 0;
    public ?Store $store = null;
    protected ?CyrismaService $cyrisma = null;
    protected $listeners = ['refreshCache'];

    public function mount(): void
    {
        $current = app('currentStore');
        $this->storeId = $current instanceof Store ? $current->id : (int) $current;
        $this->store = $current instanceof Store ? $current : Store::find($this->storeId);
    }

    public function loadScanData(): void
    {
        $this->error = null;

        $this->store = Store::find($this->storeId);

        if (! $this->store) {
            $this->error = 'Unable to load store information. Please try again later.';
            $this->loaded = true;

            return;
        }

        try {
            $this->cyrisma = app(CyrismaService::class)->forStore($this->store);
            $this->isConfigured = $this->cyrisma->isConfigured();
            $this->hasShortName = $this->cyrisma->hasShortName();

            if ($this->isConfigured && $this->hasShortName) {
                $this->hasExternalScans = $this->cyrisma->getExternalIpScanData() !== null;
                $this->hasInternalScans = $this->cyrisma->hasInternalScans();
            }
        } catch (Exception $e) {
            Log::error('Failed to load Cyrisma scan data', [
                'store_id' => $this->store->id,
                'message' => $e->getMessage(),
            ]);

            $this->error = 'Unable to connect to the scanning service. Please try again later.';
        }

        $this->loaded = true;
    }

    public function refreshCache(): void
    {
        $store = Store::find($this->storeId);

        if ($store) {
            try {
                app(CyrismaService::class)->forStore($store)->clearCache();
            } catch (Exception $e) {
                Log::error('Failed to clear cache', [
                    'store_id' => $store->id,
                    'message' => $e->getMessage(),
                ]);
            }
        }

        $this->dispatchBrowserEvent('refresh-page');
    }

    public function render(): View
    {
        return view('livewire.tenant.scans.index', [
            'cyrisma' => $this->cyrisma,
        ])->layout('components.dealer-app');
    }
}
