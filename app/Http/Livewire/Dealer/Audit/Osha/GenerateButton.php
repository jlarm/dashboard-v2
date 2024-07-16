<?php

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Jobs\Audit\GenerateOshaPdfJob;
use App\Jobs\Audit\UploadOshaPdfJob;
use App\Models\Dealer\Audit\OshaViolationAudit;
use Illuminate\Support\Facades\Bus;
use Livewire\Component;

class GenerateButton extends Component
{
    public OshaViolationAudit $oshaViolationAudit;

    public function generatePdf(): void
    {
        Bus::chain([
            new GenerateOshaPdfJob($this->oshaViolationAudit),
            new UploadOshaPdfJob($this->oshaViolationAudit),
        ])->dispatch();

        $this->emit('pdfGenerated');
    }

    public function render()
    {
        return view('livewire.dealer.audit.osha.generate-button');
    }
}
