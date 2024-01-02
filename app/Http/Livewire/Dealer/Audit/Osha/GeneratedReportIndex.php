<?php

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class GeneratedReportIndex extends Component
{
    public Store $store;

    public function render()
    {
        return view('livewire.dealer.audit.osha.generated-report-index', [
            'oshaAudits' => OshaAudit::whereNot('pdf_path', '')->orderBy('audit_date', 'desc')->select('id', 'audit_date', 'pdf_path')->get(),
        ]);
    }
}
