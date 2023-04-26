<?php

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Audit\OshaAudit;
use Filament\Notifications\Notification;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
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
        OshaAudit::destroy($this->oshaAudit->id);

        $media = Media::where('model_id', $this->oshaAudit->id);
        $media->delete();

        $this->emitTo('dealer.audit.osha.index', 'refreshAudits');

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
