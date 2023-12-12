<?php

namespace App\Http\Livewire\Central\Docs;

use App\Models\Document;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $title;
    public $file;

    protected $messages = [
        'file.max' => 'The uploaded file is too large. Please visit https://www.ilovepdf.com/compress_pdf to compress the file.'
    ];

    protected $rules = [
        'title' => 'required',
        'file' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar|max:1024'
    ];

    public function save()
    {
        try {
//            $this->validate();

//            $fileUpload = $this->file->store('documents', 'public');

            $fileName = $this->file->getClientOriginalName();

//            \Storage::disk('central-docs')->put('/', $fileName, $this->file);

            \Storage::disk('central-docs')->putFileAs('/', $this->file, $fileName);

            Document::create([
                'title' => $this->title,
                'file_name' => $fileName,
            ]);

            $this->reset();

            $this->file = null;

            $this->emit('saved');

            Notification::make()
                ->title('Document Added Successfully!')
                ->success()
                ->send();

        } catch(\Exception $e) {

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
        return view('livewire.central.docs.create');
    }
}
