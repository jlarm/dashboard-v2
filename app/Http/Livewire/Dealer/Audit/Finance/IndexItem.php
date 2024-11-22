<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\GlbaViolationAudit;
use Livewire\Component;

class IndexItem extends Component
{
    public GlbaViolationAudit $glbaViolationAudit;

    public $store;

    protected $listeners = [
        'pdfGenerated' => '$refresh',
    ];

    public function quarter(): string
    {
        return $this->glbaViolationAudit->date->format('Y').' Q'.ceil($this->glbaViolationAudit->date->format('n') / 3);
    }

    public function download()
    {
        return \Storage::disk('armpaudits')->download($this->glbaViolationAudit->pdf_path);
    }

    public function render()
    {
        return view('livewire.dealer.audit.finance.index-item');
    }
}
