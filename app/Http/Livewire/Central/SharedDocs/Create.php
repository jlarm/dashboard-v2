<?php

namespace App\Http\Livewire\Central\SharedDocs;

use App\Models\SharedDocument;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use function Sentry\captureException;

class Create extends Component
{
    use WithFileUploads;

    public string $title = '';
    public $file = null;

    protected array $rules = [
        'title' => 'required|string|min:2|max:255',
        'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar|max:10240',
    ];

    protected array $messages = [
        'file.max' => 'The uploaded file is too large. Please visit https://www.ilovepdf.com/compress_pdf to compress the file.',
    ];

    public function save(): void
    {
        $this->validate();

        DB::beginTransaction();

        try {
            if ($this->file) {
                $fileName = $this->file->getClientOriginalName();

                $fileName = str_replace(' ', '-', $fileName);

                $filePath = Storage::disk('public')->putFileAs('/shared-documents', $this->file, $fileName);

                if (! $filePath) {
                    throw new Exception("Error uploading the file");
                }
            }

            SharedDocument::create([
                'title' => $this->title,
                'file_name' => $filePath ?? null,
                'file_type' => $this->file->getClientOriginalExtension(),
            ]);

            DB::commit();

            $this->reset(['title','file']);

            Notification::make()
                ->title('Document Uploaded')
                ->success()
                ->send();
        } catch (Exception $error) {
            DB::rollBack();

            Notification::make()
                ->title('There was an error uploading the file')
                ->danger()
                ->send();

            Log::error($error->getMessage());

            captureException($error);
        }
    }

    public function render(): View
    {
        return view('livewire.central.shared-docs.create');
    }
}
