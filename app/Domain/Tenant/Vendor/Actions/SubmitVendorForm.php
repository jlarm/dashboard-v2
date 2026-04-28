<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Vendor\Actions;

use App\Domain\Tenant\Vendor\Data\SubmitVendorFormData;
use App\Domain\Tenant\Vendor\Support\RiskAssessmentQuestions;
use App\Models\Dealer\VendorForm;
use App\Models\User;
use App\Notifications\VendorSignedNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubmitVendorForm
{
    public function handle(VendorForm $vendorForm, SubmitVendorFormData $data): VendorForm
    {
        if ($data->isDocumentUpload()) {
            $path = $data->document->store(
                tenant('id').'/vendor-documents',
                'do-manuals',
            );

            $vendorForm->update(['document_path' => $path]);
        } else {
            $signatureFilename = $this->generateSignatureFilename($vendorForm);
            $signatureData = Str::after((string) $data->signature, ',');

            Storage::put('signatures/'.$signatureFilename, base64_decode($signatureData));

            $vendorForm->update([
                'data' => $this->buildResponseData($data->responses),
                'signature' => $signatureFilename,
            ]);
        }

        $this->notifyQualifiedIndividuals($vendorForm);

        return $vendorForm->refresh();
    }

    private function generateSignatureFilename(VendorForm $vendorForm): string
    {
        $sanitizedName = Str::of((string) $vendorForm->name)->replace(' ', '')->lower()->toString();

        return $sanitizedName.now()->format('YmdHis').'.png';
    }

    /**
     * @param  array<int, array{response: string, comment: string|null}>|null  $responses
     * @return array<int, array{question: string, response: string, comment: string|null}>
     */
    private function buildResponseData(?array $responses): array
    {
        $questions = RiskAssessmentQuestions::all();
        $data = [];

        foreach ($questions as $index => $question) {
            $data[$index] = [
                'question' => $question,
                'response' => $responses[$index]['response'] ?? '',
                'comment' => $responses[$index]['comment'] ?? null,
            ];
        }

        return $data;
    }

    private function notifyQualifiedIndividuals(VendorForm $vendorForm): void
    {
        $qualifiedIndividuals = User::query()->role('Qualified Individual')->get();

        if ($qualifiedIndividuals->isEmpty()) {
            return;
        }

        Notification::send($qualifiedIndividuals, new VendorSignedNotification($vendorForm));
    }
}
