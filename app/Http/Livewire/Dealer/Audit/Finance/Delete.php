<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $financeAudit;

    public function mount(FinanceAudit $financeAudit)
    {
        $this->financeAudit = $financeAudit;
    }

    public function delete()
    {
        $this->financeAudit->delete();

        $this->emitTo('dealer.audit.finance.index', 'refreshAudits');

        $this->close();

        Notification::make()
            ->title('Finance Audit Deleted Successfully!')
            ->success()
            ->send();
    }
    public function render()
    {
        return view('livewire.dealer.audit.finance.delete');
    }
}
