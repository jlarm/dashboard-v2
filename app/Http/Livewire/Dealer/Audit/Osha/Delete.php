<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Audit\OshaViolationAudit;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $oshaAudit;

    public function mount(OshaViolationAudit $oshaAudit): void
    {
        $this->oshaAudit = $oshaAudit;
    }

    public function delete(): void
    {
        $this->oshaAudit->auditComments()->delete();
        $this->oshaAudit->delete();

        $this->dispatch('refreshAudits')->to('dealer.audit.osha.index');

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

    protected function deleteViolationPhotos(): void
    {
        $this->oshaAudit->violations->each(function ($violation): void {
            $violation->clearMediaCollection('violations_files_0');
            $violation->clearMediaCollection('violations_files_1');
            $violation->clearMediaCollection('violations_files_2');
        });
    }
}
