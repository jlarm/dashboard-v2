<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $individualAudit;

    public function mount(IndividualAudit $individualAudit): void
    {
        $this->individualAudit = $individualAudit;
    }

    public function delete(): void
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

        $this->dispatchBrowserEvent('refresh-page');
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.individual.delete');
    }
}
