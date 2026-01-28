<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Docs;

use App\Models\Document;
use Exception;
use Filament\Notifications\Notification;
use Log;
use Storage;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $doc;

    public function mount(Document $doc)
    {
        $this->doc = $doc;
    }

    public function delete()
    {
        try {
            Storage::disk('central-docs')->delete($this->doc->file_name);

            $this->doc->delete();

            $this->emit('saved');

            $this->close();

            Notification::make()
                ->title('Document Deleted Successfully!')
                ->success()
                ->send();
        } catch (Exception $e) {
            Log::error($e);
            $this->addError('file', 'An error occurred while deleting the file.');
        }
    }

    public function render()
    {
        return view('livewire.central.docs.delete');
    }
}
