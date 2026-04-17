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

        $this->dispatch('refreshIndividualAudits')->to('dealer.audit.individual.index');
        $this->dispatch('refreshComponent')->to('dealer.audit.individual.show');
        $this->dispatch('refreshParentComponent')->to('dealer.audit.individual.parent-show-single');

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
