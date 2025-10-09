<?php

namespace App\Http\Livewire\Central\SharedDocs;

use App\Models\SharedDocument;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public SharedDocument $sharedDocument;
    public string $title;
    public string $url;
    public $file;
    public $newFile;
    public $removed = false;
    protected array $messages = [
        'file.max' => 'The uploaded file is too large. Please visit https://www.ilovepdf.com/compress_pdf to compress the file.',
    ];

    public function mount(): void
    {
        $this->title = $this->sharedDocument->title;
        $this->file = $this->sharedDocument->file_name;
        $this->url = $this->sharedDocument->url;
    }

    public function update(): void
    {
        $rules = [
            'title' => 'required|string|min:2|max:255',
        ];

        if (! $this->file && ! $this->url) {
            Notification::make()
                ->title('Either a URL or file is required')
                ->warning()
                ->send();

            return;
        }

        if ($this->file instanceof TemporaryUploadedFile) {
            $rules['file'] = 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar|max:10240';
        }

        if ($this->url) {
            $rules['url'] = 'url';
        }

        $this->validate($rules);

        if ($this->removed) {
            Storage::disk('public')->delete($this->sharedDocument->file_name);
            $this->sharedDocument->update([
                'file_name' => null,
            ]);
        }

        if ($this->file instanceof TemporaryUploadedFile) {
            $fileName = $this->file->getClientOriginalName();

            $fileName = str_replace(' ', '-', $fileName);

            $filePath = Storage::disk('public')->putFileAs('/shared-documents', $this->file, $fileName);

            $this->sharedDocument->update([
                'file_name' => $filePath,
            ]);
        }

        $this->sharedDocument->update([
            'title' => $this->title,
            'url' => $this->url,
        ]);

        $this->reset(['removed']);

        Notification::make()
            ->title('Document updated successfully')
            ->success()
            ->send();
    }

    public function removeDoc(): void
    {
        $this->file = null;
        $this->removed = true;
    }

    public function render(): View
    {
        return view('livewire.central.shared-docs.edit');
    }
}
