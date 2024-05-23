<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\GlbaViolationAudit;
use Livewire\Component;

class IndexItem extends Component
{
    public GlbaViolationAudit $glbaAudit;

    public $store;

    protected $listeners = [
        'pdfGenerated' => '$refresh',
    ];

    public function quarter(): string
    {
        return $this->glbaAudit->date->format('Y').' Q'.ceil($this->glbaAudit->date->format('n') / 3);
    }

    public function download()
    {
        return \Storage::disk('armpaudits')->download($this->glbaAudit->pdf_path);
    }

    public function render()
    {
        return view('livewire.dealer.audit.finance.index-item');
    }
}
