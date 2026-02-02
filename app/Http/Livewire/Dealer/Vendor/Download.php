<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\VendorForm;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class Download extends Component
{
    public VendorForm $vendorForm;

    public function download()
    {
        $pdfName = Str::replace(' ', '', $this->vendorForm->vendor->name).'.pdf';

        if ($this->vendorForm->document_path) {
            return $this->downloadUploadedDocument($pdfName);
        }

        return $this->downloadGeneratedPdf($pdfName);
    }

    public function render()
    {
        return view('livewire.dealer.vendor.download');
    }

    private function downloadUploadedDocument(string $pdfName)
    {
        $disk = Storage::disk('do-manuals');
        $path = $this->vendorForm->document_path;

        if (! $disk->exists($path)) {
            Log::error("Vendor form document not found: {$path}");

            Notification::make()
                ->title('Document not found')
                ->danger()
                ->send();

            return;
        }

        return response()->streamDownload(function () use ($disk, $path) {
            echo $disk->get($path);
        }, $pdfName, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    private function downloadGeneratedPdf(string $pdfName)
    {
        try {
            $pdf = Pdf::loadView('dealer.vendor.pdf.form-submission', ['vendor' => $this->vendorForm]);

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $pdfName, [
                'Content-Type' => 'application/pdf',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            Notification::make()
                ->title('Failed to generate PDF')
                ->danger()
                ->send();
        }
    }
}
