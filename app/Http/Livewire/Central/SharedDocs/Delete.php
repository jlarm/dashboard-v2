<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\SharedDocs;

use App\Models\SharedDocument;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $sharedDocument;

    public function mount(SharedDocument $sharedDocument): void
    {
        $this->sharedDocument = $sharedDocument;
    }

    public function delete()
    {
        try {
            if ($this->sharedDocument->file_name) {
                Storage::disk('public')->delete($this->sharedDocument->file_name);
            }

            $this->sharedDocument->delete();

            Notification::make()
                ->title('Document Deleted Successfully')
                ->success()
                ->send();

            return redirect()->route('dealer-docs.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.central.shared-docs.delete');
    }
}
