<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\GlbaViolationAudit;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $glbaAudit;

    public function mount(GlbaViolationAudit $glbaViolationAudit)
    {
        $this->glbaAudit = $glbaViolationAudit;
    }

    protected function deleteViolationPhotos(): void
    {
        $this->glbaAudit->violations->each(function ($violation) {
            $violation->clearMediaCollection('violations_files_0');
            $violation->clearMediaCollection('violations_files_1');
            $violation->clearMediaCollection('violations_files_2');
        });
    }

    public function delete()
    {
        $this->deleteViolationPhotos();

        $this->glbaAudit->delete();

        $this->emitTo('dealer.audit.finance.index', 'refreshAudits');

        $this->close();

        Notification::make()
            ->title('GLBA Audit Deleted Successfully!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.audit.finance.delete');
    }
}
