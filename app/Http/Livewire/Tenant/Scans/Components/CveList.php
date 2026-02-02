<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Scans\Components;

use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Illuminate\View\View;
use Livewire\Component;

class CveList extends Component
{
    public array $cveItems = [];

    public int $perPage = 5;

    public int $currentPage = 1;

    public string $assetType = '';

    public function mount(): void
    {
        $this->loadCveData();
    }

    public function updatedAssetType(): void
    {
        $this->currentPage = 1;
        $this->loadCveData();
    }

    protected function loadCveData(): void
    {
        $store = Store::find(app('currentStore'));

        if (! $store) {
            return;
        }

        $cyrisma = app(CyrismaService::class)->forStore($store);

        if ($this->assetType !== '') {
            // Use the scan-based filtering for specific asset types
            $data = $cyrisma->getVulnerabilitiesByAssetType($this->assetType);
            $this->cveItems = $data['vulnerabilities'] ?? [];
        } else {
            // Use the CVE dashboard for "all" view
            $data = $cyrisma->getCveDetails();
            $this->cveItems = isset($data['cve_items']) ? array_slice($data['cve_items'], 1) : [];
        }
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

    public function gotoPage($page): void
    {
        $this->currentPage = max(1, (int) $page);
    }

    public function resetToFirstPage(): void
    {
        $this->currentPage = 1;
    }

    public function render(): View
    {
        $total = count($this->cveItems);
        $offset = ($this->currentPage - 1) * $this->perPage;
        $paginatedItems = array_slice($this->cveItems, $offset, $this->perPage);
        $totalPages = (int) ceil($total / $this->perPage);

        return view('livewire.tenant.scans.components.cve-list', [
            'cves' => $paginatedItems,
            'currentPage' => $this->currentPage,
            'totalPages' => $totalPages,
            'total' => $total,
        ]);
    }
}
