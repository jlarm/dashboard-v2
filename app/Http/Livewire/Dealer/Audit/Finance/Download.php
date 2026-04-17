<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Download extends Component
{
    public FinanceAudit $financeAudit;
    public $content;

    public function mount(): void
    {

        $this->content = Storage::disk('do-audits')->url(tenant('id').'/finance/'.$this->financeAudit->pdf_path);
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.audit.finance.download');
    }
}
