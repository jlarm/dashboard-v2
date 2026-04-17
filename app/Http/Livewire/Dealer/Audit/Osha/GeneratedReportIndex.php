<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Store;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class GeneratedReportIndex extends Component
{
    public Store $store;

    public function render(): Factory|View
    {
        return view('livewire.dealer.audit.osha.generated-report-index', [
            'oshaAudits' => OshaAudit::query()->whereNot('pdf_path', '')->latest('audit_date')->select('id', 'audit_date', 'pdf_path')->get(),
        ]);
    }
}
