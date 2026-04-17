<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Manual\Cms;

use App\Models\CmsManual;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $manual;

    public function mount(CmsManual $manual): void
    {
        $this->manual = $manual;
    }

    public function delete(): void
    {
        if ($this->manual->pdf_path) {
            Storage::disk('do-manuals')->delete(tenant('id').'/cms/'.$this->manual->pdf_path);
        }

        if ($this->manual->adoption_approval_signature_one) {
            Storage::delete('cms-signatures/'.$this->manual->adoption_approval_signature_one);
        }

        if ($this->manual->adoption_approval_signature_two) {
            Storage::delete('cms-signatures/'.$this->manual->adoption_approval_signature_two);
        }

        if ($this->manual->adoption_approval_signature_three) {
            Storage::delete('cms-signatures/'.$this->manual->adoption_approval_signature_three);
        }

        if ($this->manual->adoption_approval_signature_three) {
            Storage::delete('cms-signatures/'.$this->manual->adoption_approval_signature_three);
        }

        if ($this->manual->dealer_participation_program_signature) {
            Storage::delete('cms-signatures/'.$this->manual->dealer_participation_program_signature);
        }

        if ($this->manual->acknowledgement_signature) {
            Storage::delete('cms-signatures/'.$this->manual->acknowledgement_signature);
        }

        $this->manual->delete();

        $this->close();

        $this->dispatch('$refresh');

        Notification::make()
            ->title('Manual Deleted')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.dealer.manual.cms.delete');
    }
}
