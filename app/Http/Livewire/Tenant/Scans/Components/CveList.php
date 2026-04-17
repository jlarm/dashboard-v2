<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Scans\Components;

use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Illuminate\View\View;
use Livewire\Component;

class CveList extends Component
{
    private const array ALL_ASSET_TYPES = ['internal', 'external_ip', 'external_web'];

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

    protected function loadCveData(): void
    {
        $store = Store::query()->find(resolve('currentStore'));

        if (! $store) {
            return;
        }

        $cyrisma = resolve(CyrismaService::class)->forStore($store);

        if ($this->assetType !== '') {
            // Use the scan-based filtering for specific asset types
            $data = $cyrisma->getVulnerabilitiesByAssetType($this->assetType);
            $this->cveItems = $data['vulnerabilities'] ?? [];
        } else {
            // Aggregate all scan types so "All Asset Types" matches filtered behavior.
            $this->cveItems = collect(self::ALL_ASSET_TYPES)
                ->flatMap(function (string $assetType) use ($cyrisma): array {
                    $data = $cyrisma->getVulnerabilitiesByAssetType($assetType);

                    return $data['vulnerabilities'] ?? [];
                })
                ->sortByDesc(fn (array $item): array => [
                    $this->riskRank((string) ($item['cve_risk'] ?? '')),
                    (float) ($item['cve_score'] ?? 0),
                ])
                ->values()
                ->all();
        }
    }

    private function riskRank(string $risk): int
    {
        return match (mb_strtolower($risk)) {
            'critical' => 5,
            'high' => 4,
            'medium' => 3,
            'low' => 2,
            default => 1,
        };
    }
}
