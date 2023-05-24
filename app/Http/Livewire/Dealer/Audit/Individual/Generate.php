<?php

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Jobs\GenerateIndividualAuditPdfJob;
use App\Jobs\UploadIndividualAuditToDigitalOceanJob;
use App\Models\Dealer\Audit\IndividualAudit;
use Bus;
use Livewire\Component;

class Generate extends Component
{
    public IndividualAudit $individualAudit;

    public function generatePdf(): void
    {
        Bus::chain([
            new GenerateIndividualAuditPdfJob($this->individualAudit),
            new UploadIndividualAuditToDigitalOceanJob($this->individualAudit),
        ])->dispatch();
    }
    public function render()
    {
        return view('livewire.dealer.audit.individual.generate');
    }
}
