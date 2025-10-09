<?php

namespace App\Http\Livewire\Central\Sds;

use App\Models\Sds;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Log;
use Storage;

use function Sentry\captureException;

class Edit extends Component
{
    use WithFileUploads;

    public Sds $sds;
    public string $name = '';
    public string $manufacturer = '';
    public array $keywords = [];
    public string $newKeyword = '';
    public $file;
    protected $messages = [
        'file.max' => 'The uploaded file is too large. Please visit https://www.ilovepdf.com/compress_pdf to compress the file.',
    ];
    protected $rules = [
        'name' => 'required|string|max:255',
        'manufacturer' => 'nullable|string|max:255',
        'keywords' => 'nullable|array',
    ];

    public function mount(): void
    {
        $this->name = $this->sds->name;
        $this->manufacturer = $this->sds->manufacturer ?? '';
        $this->keywords = $this->sds->keywords ?? [];
        $this->file = $this->sds->file_name;
    }

    public function deleteFile(): null
    {
        return $this->file = null;
    }

    public function update(): void
    {
        // Validate base fields
        $this->validate();

        // Validate file only if it's been uploaded (UploadedFile instance)
        if ($this->file && is_object($this->file) && method_exists($this->file, 'getClientOriginalName')) {
            $this->validate([
                'file' => 'mimes:pdf|max:5120',
            ]);
        }

        try {
            // Check if a new file was uploaded
            if ($this->file && is_object($this->file) && method_exists($this->file, 'getClientOriginalName')) {
                // Delete old file
                Storage::disk('sds-sheets')->delete($this->sds->file_name);

                $fileName = str_replace(' ', '-', $this->file->getClientOriginalName());

                // Check if file already exists (but allow current file)
                if (Sds::where('file_name', $fileName)->where('id', '!=', $this->sds->id)->exists()) {
                    $this->addError('file', 'A file with the same name already exists.');

                    return;
                }

                Storage::disk('sds-sheets')->putFileAs('/', $this->file, $fileName);
            } else {
                // No new file uploaded, keep existing file name
                $fileName = $this->sds->file_name;
            }

            $this->sds->update([
                'name' => $this->name,
                'manufacturer' => $this->manufacturer,
                'keywords' => $this->keywords,
                'file_name' => $fileName,
            ]);

            Notification::make()
                ->title('SDS Sheet Updated Successfully!')
                ->success()
                ->send();
        } catch (Exception $e) {
            Log::error($e);
            captureException($e);
            if (str_contains($e->getMessage(), 'max.')) {
                $this->addError('file', $this->messages['file.max']);
            } else {
                $this->addError('file', 'An error occurred while uploading the file.');
            }
        }
    }

    public function addKeyword(): void
    {
        if (trim($this->newKeyword) && ! in_array($this->newKeyword, $this->keywords, true)) {
            $this->keywords[] = trim($this->newKeyword);
            $this->newKeyword = '';
        }
    }

    public function removeKeyword(int $index): void
    {
        if (isset($this->keywords[$index])) {
            unset($this->keywords[$index]);
            $this->keywords = array_values($this->keywords);
        }
    }

    public function render(): View
    {
        return view('livewire.central.sds.edit');
    }
}
