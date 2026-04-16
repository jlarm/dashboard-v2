<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Http\Livewire\Concerns\ResolvesDashboardStore;
use App\Models\Dealer\Store;
use App\Services\ComplianceSummaryPdfService;
use Illuminate\View\View;
use Livewire\Component;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExecutiveSummary extends Component
{
    use ResolvesDashboardStore;

    private const AUTHORIZED_ROLES = ['super-admin', 'Owner', 'GM', 'CFO', 'GSM', 'Qualified Individual'];

    private const UNRESTRICTED_ROLES = ['super-admin', 'Consultant'];

    public ?Store $store = null;

    public function mount(): void
    {
        $this->store ??= $this->resolveDashboardStore();
    }

    public function download(ComplianceSummaryPdfService $service): BinaryFileResponse
    {
        $user = auth()->user();

        abort_unless($user?->hasAnyRole(self::AUTHORIZED_ROLES), 403);

        $store = $this->resolveDashboardStore();

        abort_unless($store instanceof Store, 404);

        abort_unless(
            $user->hasAnyRole(self::UNRESTRICTED_ROLES)
                || $user->stores()->whereKey($store->id)->exists(),
            403
        );

        $pdfPath = $service->generate(
            Store::query()->whereKey($store->id)->get(),
            now()->format('F Y'),
        );

        $fileName = implode('-', [
            now()->format('Ymd'),
            str($store->name)->slug()->toString(),
            'executive-summary.pdf',
        ]);

        return response()
            ->download($pdfPath, $fileName, ['Content-Type' => 'application/pdf'])
            ->deleteFileAfterSend(true);
    }

    public function render(): View
    {
        return view('livewire.dealer.home.executive-summary');
    }
}
