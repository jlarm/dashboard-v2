<?php

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class GeneratedReportIndex extends Component
{
    public $store;

    public function mount()
    {
        $this->store = Store::where('id', app('currentStore'))->firstOrFail();
    }

    public function render()
    {
        return view('livewire.dealer.audit.individual.generated-report-index', [
            'individualAudits' => $this->store->individualAudits()
                ->whereNot('pdf_path', '')
                ->orderBy('audit_date', 'desc')
                ->select(['id', 'audit_date', 'pdf_path'])
            ->get(),
        ]);
    }
}
