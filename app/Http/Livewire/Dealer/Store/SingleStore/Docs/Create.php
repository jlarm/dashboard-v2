<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Docs;

use App\Models\Dealer\Store;
use App\Models\DealerDoc;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public Store $store;

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
                $fileUpload = $this->file->store('dealer-docs');
            }

            DealerDoc::create([
                'store_id' => $this->store->id,
                'title' => $this->title,
                'url' => $this->url,
                'file_name' => $this->file?->getClientOriginalName() ?? '',
                'file_path' => $fileUpload ?? '',
            ]);

            $this->title = null;
            $this->url = null;
            $this->file = null;

            $this->emit('saved');

            Notification::make()
                ->title('Document Added Successfully!')
                ->success()
                ->send();
        } catch (\Exception $e) {
            \Log::error($e);
            \Sentry\captureException($e);
            if (str_contains($e->getMessage(), 'max.')) {
                $this->addError('file', $this->messages['file.max']);
            } else {
                $this->addError('file', 'An error occurred while uploading the file.');
            }
        }
    }

    public function render()
    {
        return view('livewire.dealer.store.single-store.docs.create');
    }
}
