<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Vendor\Actions;

use App\Models\Dealer\VendorForm;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadVendorForm
{
    public function handle(VendorForm $vendorForm): ?StreamedResponse
    {
        $pdfName = Str::replace(' ', '', (string) $vendorForm->vendor->name).'.pdf';

        if ($vendorForm->document_path) {
            return $this->downloadUploadedDocument($vendorForm->document_path, $pdfName);
        }

        return $this->downloadGeneratedPdf($vendorForm, $pdfName);
    }

    private function downloadUploadedDocument(string $path, string $pdfName): ?StreamedResponse
    {
        $disk = Storage::disk('do-manuals');

        if (! $disk->exists($path)) {
            return null;
        }

        return response()->streamDownload(static function () use ($disk, $path): void {
            echo $disk->get($path);
        }, $pdfName, ['Content-Type' => 'application/pdf']);
    }

    private function downloadGeneratedPdf(VendorForm $vendorForm, string $pdfName): StreamedResponse
    {
        $pdf = Pdf::loadView('dealer.vendor.pdf.form-submission', ['vendor' => $vendorForm]);

        return response()->streamDownload(static function () use ($pdf): void {
            echo $pdf->output();
        }, $pdfName, ['Content-Type' => 'application/pdf']);
    }
}
