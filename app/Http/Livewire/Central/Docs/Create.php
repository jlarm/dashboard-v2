<?php

namespace App\Http\Livewire\Central\Docs;

use App\Models\Document;
use DB;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;
use Log;
use Storage;

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
        'file' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar|max:1024',
    ];

    public function save(): void
    {
        // Validate the input data
        $this->validate();

        // Begin a database transaction
        DB::beginTransaction();

        try {
            $fileName = $this->file->getClientOriginalName();

            // Attempt to upload the file
            $filePath = Storage::disk('central-docs')->putFileAs('/', $this->file, $fileName);

            // Check if the file was successfully uploaded
            if (!$filePath) {
                throw new \Exception('File upload failed. Please try again.');
            }

            // Create the Document record in the database
            Document::create([
                'title' => $this->title,
                'file_name' => $fileName,
            ]);

            // Commit the transaction since both operations succeeded
            DB::commit();

            // Reset the form fields
            $this->reset(['title', 'file']);

            // Emit the 'saved' event
            $this->emit('saved');

            // Send a success notification
            Notification::make()
                ->title('Document Added Successfully!')
                ->success()
                ->send();

        } catch (\Exception $e) {
            // Rollback the transaction in case of any failure
            DB::rollBack();

            // Log the error for debugging
            Log::error($e);
            \Sentry\captureException($e);

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
