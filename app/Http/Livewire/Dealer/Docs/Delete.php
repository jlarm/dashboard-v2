<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Docs;

use App\Models\DealerDoc;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $doc;

    public function mount(DealerDoc $doc): void
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
                ->title('Document Deleted Successfully!')
                ->success()
                ->send();
        } catch (Exception $e) {
            Log::error($e->getMessage(), ['exception' => $e]);
            $this->addError('file', 'An error occurred while deleting the file.');
        }
    }

    public function render()
    {
        return view('livewire.dealer.docs.delete');
    }
}
