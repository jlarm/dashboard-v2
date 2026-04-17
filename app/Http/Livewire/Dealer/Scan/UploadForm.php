<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Scan;

use App\Models\Dealer\ScanReport;
use App\Models\Dealer\Store;
use Carbon\Carbon;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

use function Sentry\captureException;

class UploadForm extends Component
{
    use WithFileUploads;

    public ?Store $store = null;
    public string $scanType = '';
    public string $summaryType = '';
    public $date;
    public $file;
    protected $rules = [
        'scanType' => 'required|string',
        'summaryType' => 'required|string',
        'date' => 'nullable|date',
        'file' => 'required|mimes:pdf|max:10240',
    ];

    public function save(): void
    {
        try {
            $this->validate();

            $fileUpload = Storage::disk('do-scans')->putFileAs(tenant('id'), $this->file, $this->file->getClientOriginalName());

            $storeId = $this->store->id ?? Store::query()->first()->id;

            $data = [
                'user_id' => auth()->id(),
                'store_id' => $storeId,
                'path' => $fileUpload,
                'scan_type' => mb_strtolower($this->scanType),
                'type' => mb_strtolower($this->summaryType),
            ];

            if ($this->date) {
                $customDate = Carbon::parse($this->date)->startOfDay();
                $data['created_at'] = $customDate;
                $data['updated_at'] = $customDate;
            }

            ScanReport::query()->create($data);

            $this->reset();

            $this->file = null;

            Notification::make()
                ->title('Report Uploaded Successfully')
                ->success()
                ->send();

            $this->dispatch('upload-finished');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            captureException($e);

            Notification::make()
                ->title('Upload Failed')
                ->body($e->getMessage())
                ->danger()
                ->send();

            $this->dispatch('upload-error');
        }
    }

    public function render(): View
    {
        return view('livewire.dealer.scan.upload-form');
    }
}
