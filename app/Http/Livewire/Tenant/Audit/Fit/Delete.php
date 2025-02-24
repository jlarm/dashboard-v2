<?php

namespace App\Http\Livewire\Tenant\Audit\Fit;

use App\Models\FitTestDoc;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $doc;

    public function mount(FitTestDoc $doc): void
    {
        $this->doc = $doc;
    }

    public function delete(): void
    {
        try {
            Storage::disk('dealer-docs')->delete($this->doc->file_path);

            $this->doc->delete();

            $this->emit('saved');

            $this->close();

            Notification::make()
                ->title('Document Deleted Successfully')
                ->success()
                ->send();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            $this->addError('file', 'An error occurred while deleting the document.');
        }
    }

    public function render(): View
    {
        return view('livewire.tenant.audit.fit.delete');
    }
}
