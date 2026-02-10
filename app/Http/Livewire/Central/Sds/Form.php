<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Sds;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use function Sentry\captureException;
use App\Models\Sds;
use Exception;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public ?Sds $sds = null;
    public string $name = '';
    public string $productIdentifier = '';
    public array $productIdentificationNumbers = [];
    public string $newPin = '';
    public string $manufacturer = '';
    public array $casNos = [];
    public string $newCasNo = '';
    public string $commonName = '';
    public $file;
    protected $rules = [
        'name' => 'required|string|max:255',
        'productIdentifier' => 'nullable|string|max:255',
        'productIdentificationNumbers' => 'nullable|array',
        'manufacturer' => 'nullable|string|max:255',
        'casNos' => 'nullable|array',
        'commonName' => 'nullable|string|max:255',
        'file' => 'nullable|mimes:pdf|max:5120',
    ];

    public function mount(): void
    {
        $this->sds ??= new Sds;
        $this->name = $this->sds->name ?? '';
        $this->productIdentifier = $this->sds->product_identifier ?? '';
        $this->productIdentificationNumbers = $this->sds->product_identification_numbers;
        $this->manufacturer = $this->sds->manufacturer ?? '';
        $this->casNos = [$this->sds->cas_nos];
        $this->commonName = $this->sds->common_name ?? '';
    }

    public function addPin(): void
    {
        if (trim($this->newPin) !== '' && ! in_array($this->newPin, $this->productIdentificationNumbers)) {
            $this->productIdentificationNumbers[] = $this->newPin;
            $this->newPin = '';
        }
    }

    public function addCas(): void
    {
        if (trim($this->newCasNo) !== '' && ! in_array($this->newCasNo, $this->casNos)) {
            $this->casNos[] = $this->newCasNo;
            $this->newCasNo = '';
        }
    }

    public function removePin($index): void
    {
        unset($this->productIdentificationNumbers[$index]);
        $this->productIdentificationNumbers = array_values($this->productIdentificationNumbers);
    }

    public function removeCas($index): void
    {
        unset($this->casNos[$index]);
        $this->casNos = array_values($this->casNos);
    }

    public function create(): void
    {
        try {
            $fileName = str_replace(' ', '-', $this->file->getClientOriginalName());
            Storage::disk('sds-sheets')->putFileAs('/', $this->file, $fileName);

            Sds::query()->create([
                'name' => $this->name,
                'product_identifier' => $this->productIdentifier,
                'product_identification_numbers' => json_encode($this->productIdentificationNumbers),
                'manufacturer' => $this->manufacturer,
                'cas_nos' => json_encode($this->casNos),
                'common_name' => $this->commonName,
                'pdf_path' => $fileName,
            ]);

            $this->reset([
                'name',
                'productIdentifier',
                'productIdentificationNumbers',
                'newPin',
                'manufacturer',
                'casNos',
                'newCasNo',
                'commonName',
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

    public function render()
    {
        return view('livewire.central.sds.form');
    }
}
