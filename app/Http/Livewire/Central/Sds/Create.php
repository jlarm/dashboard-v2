<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Sds;

use App\Models\Sds;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

use function Sentry\captureException;

class Create extends Component
{
    use WithFileUploads;

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
        'file' => 'nullable|mimes:pdf|max:5120',
    ];

    public function create(): void
    {
        $this->validate();

        try {
            $fileName = str_replace(' ', '-', $this->file->getClientOriginalName());

            if (Sds::query()->where('file_name', $fileName)->exists()) {
                $this->addError('file', 'A file with the same name already exists.');

                return;
            }

            Storage::disk('sds-sheets')->putFileAs('/', $this->file, $fileName);

            Sds::query()->create([
                'name' => $this->name,
                'manufacturer' => $this->manufacturer,
                'keywords' => $this->keywords,
                'file_name' => $fileName,
            ]);

            $this->reset([
                'name',
                'manufacturer',
                'keywords',
                'file',
            ]);

            $this->file = null;

            Notification::make()
                ->title('SDS Sheet Added Successfully!')
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
        return view('livewire.central.sds.create')->layout('layouts.app');
    }
}
