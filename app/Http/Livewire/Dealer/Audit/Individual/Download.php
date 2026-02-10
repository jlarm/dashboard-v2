<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Download extends Component
{
    public IndividualAudit $individualAudit;
    public $content;

    public function mount(): void
    {

        $this->content = Storage::disk('do-audits')->url(tenant('id').'/individual-audits/'.$this->individualAudit->pdf_path);
    }

    public function render()
    {
        return view('livewire.dealer.audit.individual.download');
    }
}
