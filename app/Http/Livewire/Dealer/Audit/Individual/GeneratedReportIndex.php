<?php

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class GeneratedReportIndex extends Component
{
    public Store $store;
    public function render()
    {
        return view('livewire.dealer.audit.individual.generated-report-index', [
            'individualAudits' => IndividualAudit::where('parent_id', null)
                ->whereNot('pdf_path', '')
                ->orderBy('audit_date', 'desc')
                ->select('id', 'audit_date', 'pdf_path')
                ->where('store_id', $this->store->id)
                ->get()
        ]);
    }
}
