<?php

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use Livewire\Component;
use Storage;

class Download extends Component
{
    public IndividualAudit $individualAudit;

    public $content;

    public function mount()
    {

        $this->content = Storage::disk('do-audits')->url(tenant('id') . '/individual-audits/' . $this->individualAudit->pdf_path);
    }

    public function render()
    {
        return view('livewire.dealer.audit.individual.download');
    }
}
