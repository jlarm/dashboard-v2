<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Scans\Components;

use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Illuminate\View\View;
use Livewire\Component;

class OpenPorts extends Component
{
    public array $openPorts = [];
    public string $assetType = '';
    public int $perPage = 5;
    public int $currentPage = 1;

    public function mount(): void
    {
        $this->loadOpenPorts();
    }

    public function updatedAssetType(): void
    {
        $this->currentPage = 1;
        $this->loadOpenPorts();
    }

    public function nextPage(): void
    {
        $this->currentPage++;
    }

    public function previousPage(): void
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
        }
    }

    public function gotoPage(int $page): void
    {
        $this->currentPage = max(1, $page);
    }

    public function render(): View
    {
        $total = count($this->openPorts);
        $offset = ($this->currentPage - 1) * $this->perPage;
        $paginatedItems = array_slice($this->openPorts, $offset, $this->perPage);
        $totalPages = (int) ceil($total / $this->perPage);

        return view('livewire.tenant.scans.components.open-ports', [
            'paginatedPorts' => $paginatedItems,
            'currentPage' => $this->currentPage,
            'totalPages' => $totalPages,
            'total' => $total,
        ]);
    }

    protected function loadOpenPorts(): void
    {
        $store = Store::find(app('currentStore'));

        if (! $store) {
            return;
        }

        $this->openPorts = app(CyrismaService::class)
            ->forStore($store)
            ->getOpenPortsByAssetType($this->assetType);
    }
}
