<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Store;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class GeneratedReportIndex extends Component
{
    public $store;

    public function mount(): void
    {
        $this->store = $this->resolveStore();
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.audit.individual.generated-report-index', [
            'individualAudits' => $this->store->individualAudits()
                ->whereNot('pdf_path', '')
                ->orderBy('audit_date', 'desc')
                ->select(['id', 'audit_date', 'pdf_path'])
                ->get(),
        ]);
    }

    private function resolveStore(): Store
    {
        $currentStore = app()->bound('currentStore') ? resolve('currentStore') : null;

        if (is_numeric($currentStore)) {
            $store = Store::query()->find((int) $currentStore);

            if ($store instanceof Store) {
                return $store;
            }
        }

        $scopedStoreIds = app()->bound('scopedStoreIds') ? resolve('scopedStoreIds') : collect();
        $firstScopedStoreId = $scopedStoreIds->first();

        if (is_numeric($firstScopedStoreId)) {
            $store = Store::query()->find((int) $firstScopedStoreId);

            if ($store instanceof Store) {
                return $store;
            }
        }

        return Store::query()->orderBy('id')->firstOrFail();
    }
}
