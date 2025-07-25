<?php

namespace App\Http\Livewire\Dealer\Docs;

use App\Models\Dealer\Store;
use App\Models\DealerDoc;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Log;

use function Sentry\captureException;

class Create extends Component
{
    use WithFileUploads;

    public $title;

    public $url;

    public $file;

    protected $messages = [
        'file.max' => 'The uploaded file is too large. Please visit https://www.ilovepdf.com/compress_pdf to compress the file.',
    ];

    protected $rules = [
        'title' => 'required',
        'url' => 'nullable|url',
        'file' => 'nullable|mimes:pdf|max:10240',
    ];

    public function save(): void
    {
        try {
            $this->validate();

            if ($this->file) {
                $fileUpload = $this->file->store(tenant()->id, 'dealer-docs');
            }

            DealerDoc::create([
                'store_id' => Store::first()->id,
                'title' => $this->title,
                'url' => $this->url,
                'file_name' => $this->file?->getClientOriginalName() ?? '',
                'file_path' => $fileUpload ?? '',
            ]);

            $this->reset();

            $this->file = null;

            $this->emit('saved');

            Notification::make()
                ->title('Document Added Successfully!')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Log::error($e);
            captureException($e);
            if (str_contains($e->getMessage(), 'max.')) {
                $this->addError('file', $this->messages['file.max']);
            } else {
                $this->addError('file', 'An error occurred while uploading the file.');
            }
        }
    }

    public function render(): View
    {
        return view('livewire.dealer.docs.create');
    }
}
