<?php

namespace App\Http\Livewire\Dealer\Docs;

use App\Models\Dealer\Store;
use App\Models\DealerDoc;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $title;

    public $file;

    protected $messages = [
        'file.max' => 'The uploaded file is too large. Please visit https://www.ilovepdf.com/compress_pdf to compress the file.',
    ];

    protected $rules = [
        'title' => 'required',
        'file' => 'required|mimes:pdf|max:1024',
    ];

    public function save()
    {
        try {
            //            $this->validate();

            $fileUpload = $this->file->store(tenant()->id, 'dealer-docs');

            DealerDoc::create([
                'store_id' => Store::first()->id,
                'title' => $this->title,
                'file_name' => $this->file->getClientOriginalName(),
                'file_path' => $fileUpload,
            ]);

            $this->reset();

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
        return view('livewire.dealer.docs.create');
    }
}
