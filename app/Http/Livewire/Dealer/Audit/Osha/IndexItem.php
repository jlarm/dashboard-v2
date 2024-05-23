<?php

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Audit\OshaViolationAudit;
use Livewire\Component;

class IndexItem extends Component
{
    public OshaViolationAudit $oshaAudit;

    public $store;

    protected $listeners = [
        'pdfGenerated' => '$refresh',
    ];

    public function quarter(): string
    {
        return $this->oshaAudit->date->format('Y').' Q'.ceil($this->oshaAudit->date->format('n') / 3);
    }

    public function download()
    {
        return \Storage::disk('armpaudits')->download($this->oshaAudit->pdf_path);
    }

    public function render()
    {
        return view('livewire.dealer.audit.osha.index-item');
    }
}
