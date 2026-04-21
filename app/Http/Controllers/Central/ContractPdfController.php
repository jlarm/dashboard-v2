<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Domain\Central\Contracts\Actions\GenerateContractPdf;
use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContractPdfController extends Controller
{
    public function generate(Contract $contract, GenerateContractPdf $action): RedirectResponse
    {
        $this->authorize('generatePdf', $contract);

        $action->handle($contract);

        return back()->with('flash.success', 'PDF generation has been queued.');
    }

    public function download(Contract $contract): StreamedResponse
    {
        $this->authorize('downloadPdf', $contract);

        return Storage::disk('armpcon')->download((string) $contract->pdf_path);
    }
}
