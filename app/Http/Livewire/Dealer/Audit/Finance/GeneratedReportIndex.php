<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use Livewire\Component;

class GeneratedReportIndex extends Component
{
    public function render()
    {
        return view('livewire.dealer.audit.finance.generated-report-index', [
            'financeAudits' => FinanceAudit::query()->whereNot('pdf_path', '')->orderBy('audit_date', 'desc')->select('id', 'audit_date', 'pdf_path')->get(),
        ]);
    }
}
