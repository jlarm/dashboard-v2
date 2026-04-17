<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Store;
use App\Services\ComplianceSummaryPdfService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class GroupExecutiveSummary extends Component
{
    private const array AUTHORIZED_ROLES = ['super-admin', 'Owner', 'GM', 'CFO', 'GSM', 'Qualified Individual'];

    private const array UNRESTRICTED_ROLES = ['super-admin'];

    public function download(ComplianceSummaryPdfService $service): BinaryFileResponse
    {
        abort_unless(auth()->user()?->hasAnyRole(self::AUTHORIZED_ROLES), 403);

        $stores = $this->resolveStores();

        abort_if($stores->isEmpty(), 404);

        $reportPeriod = now()->format('F Y');
        $pdfPath = $service->generate($stores, $reportPeriod);

        $fileName = implode('-', array_filter([
            now()->format('Ymd'),
            str((string) tenant('name'))->slug()->toString() ?: 'group',
            'executive-summary.pdf',
        ]));

        return response()
            ->download($pdfPath, $fileName, ['Content-Type' => 'application/pdf'])
            ->deleteFileAfterSend(true);
    }

    public function render(): View
    {
        return view('livewire.dealer.home.group-executive-summary');
    }

    /**
     * @return Collection<int, Store>
     */
    private function resolveStores(): Collection
    {
        $user = auth()->user();

        if ($user?->hasAnyRole(self::UNRESTRICTED_ROLES)) {
            return Store::query()->get();
        }

        return $user->stores()->get();
    }
}
