<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Jobs\GenerateOshaAuditJob;
use App\Jobs\UploadOshaAuditToDigitalOceanJob;
use App\Models\Dealer\Audit\OshaAudit;
use Illuminate\Support\Facades\Bus;
use Livewire\Component;

class Generate extends Component
{
    public OshaAudit $oshaAudit;

    public function generatePdf(): void
    {
        Bus::chain([
            new GenerateOshaAuditJob($this->oshaAudit),
            new UploadOshaAuditToDigitalOceanJob($this->oshaAudit),
        ])->dispatch();
    }

    public function render()
    {
        return view('livewire.dealer.audit.osha.generate');
    }
}
