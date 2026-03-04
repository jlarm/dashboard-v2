<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Docs;

use App\Models\Document;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

use function Sentry\captureException;

class Create extends Component
{
    use WithFileUploads;

    public $title;
    public $file;
    public $url;
    protected $messages = [
        'file.max' => 'The uploaded file is too large. Please visit https://www.ilovepdf.com/compress_pdf to compress the file.',
    ];
    protected $rules = [
        'title' => 'required',
        'url' => 'nullable|url',
        'file' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar|max:10240',
    ];

    public function save(): void
    {
        // Validate the input data
        $this->validate();

        // Begin a database transaction
        DB::beginTransaction();

        try {
            if (! $this->url && ! $this->file) {

                Notification::make()
                    ->title('Please provide a URL or upload a file.')
                    ->warning()
                    ->send();
                throw new Exception('Please provide a URL or upload a file.');
            }

            if ($this->file) {
                $fileName = $this->file->getClientOriginalName();

                // Attempt to upload the file
                $filePath = Storage::disk('central-docs')->putFileAs('/', $this->file, $fileName);

                throw_unless($filePath, new Exception('File upload failed. Please try again.'));
            }

            // Create the Document record in the database
            Document::query()->create([
                'title' => $this->title,
                'url' => $this->url,
                'file_name' => $fileName ?? '',
            ]);

            // Commit the transaction since both operations succeeded
            DB::commit();

            // Reset the form fields
            $this->reset(['title', 'url', 'file']);

            // Emit the 'saved' event
            $this->emit('saved');

            // Send a success notification
            Notification::make()
                ->title('Document Added Successfully!')
                ->success()
                ->send();

        } catch (Exception $e) {
            // Rollback the transaction in case of any failure
            DB::rollBack();

            Notification::make()
                ->title('There was an error adding the file. Please try again.')
                ->danger()
                ->send();

            // Log the error for debugging
            Log::error($e->getMessage(), ['exception' => $e]);
            captureException($e);

            // Handle specific error messages
            if (str_contains($e->getMessage(), 'max.')) {
                $this->addError('file', $this->messages['file.max']);
            } else {
                $this->addError('file', $e->getMessage());
            }
        }
    }

    public function render()
    {
        return view('livewire.central.docs.create');
    }
}
