<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Scans;

use App\Jobs\Scans\GenerateCyrismaReportJob;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\CyrismaService;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public bool $loaded = false;
    public bool $showOverview = false;
    public bool $isConfigured = false;
    public bool $hasShortName = false;
    public bool $hasScanData = false;
    public bool $hasExternalScans = false;
    public bool $hasInternalScans = false;
    public ?string $error = null;
    public int $storeId = 0;
    public ?Store $store = null;
    public Collection $overviewStores;
    protected ?CyrismaService $cyrisma = null;
    protected $listeners = ['refreshCache', 'queueReport'];

    public function mount(): void
    {
        $this->overviewStores = collect();

        $this->store = app()->bound('currentStoreModel') ? app('currentStoreModel') : null;
        $this->storeId = $this->store instanceof Store ? $this->store->id : (int) app('currentStore');

        $scopedStoreIds = $this->resolveScopedStoreIds();

        if ((! $this->store instanceof Store || $this->storeId === 0) && $scopedStoreIds->count() === 1) {
            $this->storeId = (int) $scopedStoreIds->first();
            $this->store = Store::query()->find($this->storeId);
        }

        if ((! $this->store instanceof Store || $this->storeId === 0) && $scopedStoreIds->count() !== 1) {
            $this->showOverview = true;
            $this->overviewStores = Store::query()
                ->whereIn('id', $scopedStoreIds)
                ->withCount('scanReports')
                ->with('latestScanReportDate')
                ->orderBy('name')
                ->get();
            $this->loaded = true;
        }
    }

    public function loadScanData(): void
    {
        if ($this->showOverview) {
            return;
        }

        $this->error = null;
        $this->hasScanData = false;
        $this->hasExternalScans = false;
        $this->hasInternalScans = false;

        $this->store = Store::query()->find($this->storeId);

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
                $vulnerabilityScans = $this->cyrisma->getVulnerabilityScans();
                $this->hasScanData = ! empty($vulnerabilityScans['vulnerability_scans'] ?? []);
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

        $this->dispatch('scan-loaded', showDownloads: $this->isConfigured && $this->hasShortName);
    }

    public function queueReport(string $type): void
    {
        $allowedTypes = ['executive', 'technical'];
        if (! in_array($type, $allowedTypes, true)) {
            return;
        }

        $store = Store::query()->find($this->storeId);
        $user = auth()->user();

        if (! $store instanceof Store || ! $user instanceof User) {
            return;
        }

        // If already cached, open it directly instead of re-queuing
        $pdfCacheKey = sprintf('cyrisma_report_pdf_v2_%d_%s', $store->id, $type);
        if (Cache::has($pdfCacheKey)) {
            $this->dispatch('report-button-reset', type: $type);
            $this->dispatch('open-report-url', url: route('dealer.scan.report', ['type' => $type]));

            return;
        }

        // If a job is already running for this store/type, let the user know
        $lockKey = 'laravel_unique_job:'.GenerateCyrismaReportJob::class.'-'.$store->id.'-'.$type;
        if (Cache::has($lockKey)) {
            $this->dispatch('report-button-reset', type: $type);
            Notification::make()
                ->title('Report already being generated')
                ->body('Your '.ucfirst($type).' report is already being generated. You\'ll receive a notification when it\'s ready.')
                ->warning()
                ->send();

            return;
        }

        Log::info('queueReport: dispatching job', ['store_id' => $store->id, 'type' => $type, 'user_id' => $user->id]);

        GenerateCyrismaReportJob::dispatch($store->id, $type, $user->id);

        Log::info('queueReport: job dispatched', ['store_id' => $store->id, 'type' => $type]);

        $this->dispatch('report-button-reset', type: $type);

        Notification::make()
            ->title(ucfirst($type).' report queued')
            ->body('Your report is being generated in the background. You\'ll receive a notification here when it\'s ready to download.')
            ->warning()
            ->send();
    }

    public function refreshCache(): void
    {
        $store = Store::query()->find($this->storeId);

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

        $this->dispatch('refresh-page');
    }

    public function render(): View
    {
        return view('livewire.tenant.scans.index', [
            'cyrisma' => $this->cyrisma,
        ])->layout('components.dealer-app');
    }

    private function resolveScopedStoreIds(): Collection
    {
        if (app()->bound('scopedStoreIds')) {
            /** @var Collection $storeIds */
            $storeIds = app('scopedStoreIds');

            $normalizedStoreIds = $storeIds->map(static fn ($id): int => (int) $id)->values();

            if ($normalizedStoreIds->isNotEmpty()) {
                return $normalizedStoreIds;
            }
        }

        $user = auth()->user();

        if (! $user) {
            return collect();
        }

        if ($user->hasAnyRole(['super-admin', 'Consultant'])) {
            return $user->current_store_id !== null
                ? collect([(int) $user->current_store_id])
                : Store::query()->pluck('id');
        }

        $assignedStoreIds = $user->stores()->pluck('stores.id')->map(static fn ($id): int => (int) $id);

        if ($user->current_store_id === null) {
            return $assignedStoreIds;
        }

        if ($assignedStoreIds->contains($user->current_store_id)) {
            return collect([(int) $user->current_store_id]);
        }

        return collect();
    }
}
