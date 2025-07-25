<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\GlbaViolationAudit;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class GenerateRemediationButton extends Component
{
    public GlbaViolationAudit $glbaViolationAudit;

    public function downloadPdf()
    {
        return Storage::disk('armpaudits')->download($this->glbaViolationAudit->remediation_pdf_path);
    }

    public function render()
    {
        return view('livewire.dealer.audit.finance.generate-remediation-button');
    }
}
