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

        if(tenant('locations')) {
            $this->emitTo('dealer.store.single-store.audit.finance.index', 'refreshAudits');
        } else {
            $this->emitTo('dealer.audit.finance.index', 'refreshAudits');
        }



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
