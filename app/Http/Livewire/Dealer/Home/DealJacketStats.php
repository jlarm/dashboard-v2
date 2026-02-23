<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Jobs\Audit\GenerateDealJacketReportJob;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DealJacketStats extends Component
{
    public Store $store;

    public function mount(): void
    {
        $this->store ??= (app()->bound('currentStoreModel') ? app('currentStoreModel') : null) ?? Store::query()->first();
    }

    public function rating(): string
    {
        $avg = $this->getAveragePercentage();

        if ($avg === null) {
            return 'N/A';
        }

        return match (true) {
            $avg >= 90 => 'A',
            $avg >= 80 => 'B',
            $avg >= 70 => 'C',
            $avg >= 60 => 'D',
            default => 'F',
        };
    }

    public function canDownload(): bool
    {
        return $this->latestCompletedGroup() instanceof DealJacketGroup;
    }

    public function download(): StreamedResponse|Response|null
    {
        $dealJacketGroup = $this->latestCompletedGroup();

        if (! $dealJacketGroup instanceof DealJacketGroup) {
            $this->addError('download', 'No completed deal jacket group found.');

            return null;
        }

        $user = auth()->user();

        abort_unless($user, 403);

        GenerateDealJacketReportJob::dispatchSync($dealJacketGroup, $user);

        $fileName = $this->buildReportFileName($dealJacketGroup);
        $filePath = "deal-jacket-reports/{$fileName}";

        abort_unless(Storage::exists($filePath), 404, 'Report not found or has expired.');

        return Storage::download($filePath, $fileName, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function render(): View
    {
        return view('livewire.dealer.home.deal-jacket-stats');
    }

    private function getAveragePercentage(): ?float
    {
        $completedGroups = DealJacketGroup::query()
            ->where('store_id', $this->store->id)
            ->where('completed', true)
            ->withSum('dealJackets as total_passed', 'total_passed')
            ->withSum('dealJackets as total_failed', 'total_failed')
            ->get();

        if ($completedGroups->isEmpty()) {
            return null;
        }

        $totalPassRate = $completedGroups->sum(fn ($group) => $group->pass_rate);

        return $totalPassRate / $completedGroups->count();
    }

    private function latestCompletedGroup(): ?DealJacketGroup
    {
        return DealJacketGroup::query()
            ->where('store_id', $this->store->id)
            ->where('completed', true)
            ->latest('id')
            ->first();
    }

    private function buildReportFileName(DealJacketGroup $dealJacketGroup): string
    {
        $storeName = str_replace(' ', '-', (string) $dealJacketGroup->store->name);
        $date = $dealJacketGroup->created_at->format('Ymd-His');

        return "{$date}-{$storeName}-deal-jacket-report.pdf";
    }
}
