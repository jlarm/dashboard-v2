<?php

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use Livewire\Component;
use Storage;

class Download extends Component
{
    public IndividualAudit $individualAudit;

    public function download()
    {
        return Storage::disk('do-audits')->download(tenant('id') . '/individual/' . $this->individualAudit->pdf_path);
    }
    public function render()
    {
        return view('livewire.dealer.audit.individual.download');
    }
}
