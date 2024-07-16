<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Jobs\Audit\GenerateGlbaPdfJob;
use App\Jobs\Audit\UploadGlbaPdfJob;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use Illuminate\Support\Facades\Bus;
use Livewire\Component;

class GenerateButton extends Component
{
    public GlbaViolationAudit $glbaAudit;

    public function generatePdf(): void
    {
        Bus::chain([
            new GenerateGlbaPdfJob($this->glbaAudit),
            new UploadGlbaPdfJob($this->glbaAudit),
        ])->dispatch();

        $this->emit('pdfGenerated');
    }

    public function render()
    {
        return view('livewire.dealer.audit.finance.generate-button');
    }
}
