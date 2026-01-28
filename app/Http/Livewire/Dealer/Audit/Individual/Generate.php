<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Jobs\GenerateIndividualAuditPdfJob;
use App\Jobs\UploadIndividualAuditToDigitalOceanJob;
use App\Models\Dealer\Audit\IndividualAudit;
use Bus;
use Livewire\Component;

class Generate extends Component
{
    public IndividualAudit $individualAudit;
    public $managerCheck;

    public function mount(IndividualAudit $individualAudit)
    {
        $this->managerCheck = IndividualAudit::query()
            ->where('id', $individualAudit->id)
            ->orWhere('parent_id', $individualAudit->id)
            ->pluck('manager_id');

        if (in_array(null, $this->managerCheck->toArray())) {
            $this->managerCheck = false;
        } else {
            $this->managerCheck = true;
        }
    }

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
