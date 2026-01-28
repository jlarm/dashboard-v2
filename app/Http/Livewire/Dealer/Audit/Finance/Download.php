<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use Livewire\Component;
use Storage;

class Download extends Component
{
    public FinanceAudit $financeAudit;
    public $content;

    public function mount()
    {

        $this->content = Storage::disk('do-audits')->url(tenant('id').'/finance/'.$this->financeAudit->pdf_path);
    }

    public function render()
    {
        return view('livewire.dealer.audit.finance.download');
    }
}
