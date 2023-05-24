<?php

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Audit\OshaAudit;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $oshaAudit;

    public function mount(OshaAudit $oshaAudit)
    {
        $this->oshaAudit = $oshaAudit;
    }

    public function delete()
    {
        $this->oshaAudit->delete();

        $this->emitTo('dealer.audit.osha.index', 'refreshAudits');
        $this->emitTo('dealer.store.single-store.audit.osha.index', 'refreshAudits');

        $this->close();

        Notification::make()
            ->title('Osha Audit Deleted Successfully!')
            ->success()
            ->send();
    }
    public function render()
    {
        return view('livewire.dealer.audit.osha.delete');
    }
}
