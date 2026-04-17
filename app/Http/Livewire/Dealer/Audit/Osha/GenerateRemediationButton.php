<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Audit\OshaViolationAudit;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class GenerateRemediationButton extends Component
{
    public OshaViolationAudit $oshaViolationAudit;

    public function downloadPdf()
    {
        return Storage::disk('armpaudits')->download($this->oshaViolationAudit->remediation_pdf_path);
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.audit.osha.generate-remediation-button');
    }
}
