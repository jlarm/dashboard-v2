<?php

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $individualAudit;

    public function mount(IndividualAudit $individualAudit)
    {
        $this->individualAudit = $individualAudit;
    }

    public function delete()
    {
        $this->individualAudit->delete();

        $this->emitTo('dealer.audit.individual.index', 'refreshIndividualAudits');
        $this->emitTo('dealer.store.single-store.audit.individual.index', 'refreshIndividualAudits');
        $this->emitTo('dealer.audit.individual.show', 'refreshComponent');
        $this->emitTo('dealer.audit.individual.parent-show-single', 'refreshParentComponent');

        $this->close();

        Notification::make()
            ->title('Individual Audit Deleted Successfully!')
            ->success()
            ->send();
    }
    public function render()
    {
        return view('livewire.dealer.audit.individual.delete');
    }
}
