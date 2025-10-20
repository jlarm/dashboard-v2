<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket;

use App\Jobs\Audit\GenerateDealJacketReportJob;
use App\Models\Dealer\Audit\DealJacketGroup;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class GenerateReport extends Modal
{
    public int $dealJacketGroupId;
    public DealJacketGroup $dealJacketGroup;
    public bool $generating = false;

    public function mount(): void
    {
        $this->dealJacketGroup = DealJacketGroup::with(['dealJackets.user', 'store'])
            ->withCount('dealJackets')
            ->withSum('dealJackets as total_passed', 'total_passed')
            ->withSum('dealJackets as total_failed', 'total_failed')
            ->findOrFail($this->dealJacketGroupId);
    }

    public function generate(): void
    {
        if (! $this->dealJacketGroup->completed) {
            $this->addError('generation', 'The deal jacket group must be completed before generating a report.');

            return;
        }

        $this->generating = true;

        GenerateDealJacketReportJob::dispatch($this->dealJacketGroup, auth()->user());

        $this->close();

        Notification::make()
            ->title('Deal Jacket Report Generation Started')
            ->body('The report is being generated in the background and will be saved to your storage.')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.tenant.audit.deal-jacket.generate-report');
    }
}
