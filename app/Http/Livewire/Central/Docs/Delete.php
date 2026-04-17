<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Docs;

use App\Models\Document;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $doc;

    public function mount(Document $doc): void
    {
        $this->doc = $doc;
    }

    public function delete(): void
    {
        try {
            Storage::disk('central-docs')->delete($this->doc->file_name);

            $this->doc->delete();

            $this->dispatch('saved');

            $this->close();

            Notification::make()
                ->title('Document Deleted Successfully!')
                ->success()
                ->send();
        } catch (Exception $e) {
            Log::error($e->getMessage(), ['exception' => $e]);
            $this->addError('file', 'An error occurred while deleting the file.');
        }
    }

    public function render(): Factory|View
    {
        return view('livewire.central.docs.delete');
    }
}
