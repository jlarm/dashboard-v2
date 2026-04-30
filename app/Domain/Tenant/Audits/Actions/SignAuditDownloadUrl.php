<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Actions;

use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SignAuditDownloadUrl
{
    public function downloadAuditPdf(ViolationAudit&Model $audit): StreamedResponse
    {
        abort_if(empty($audit->pdf_path), 404);

        return Storage::disk('armpaudits')->download($audit->pdf_path);
    }

    public function downloadRemediationPdf(ViolationAudit&Model $audit): StreamedResponse
    {
        abort_if(empty($audit->remediation_pdf_path), 404);

        return Storage::disk('armpaudits')->download($audit->remediation_pdf_path);
    }
}
