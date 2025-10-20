<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Audit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DealJacketReportDownloadController extends Controller
{
    public function download(string $fileName): BinaryFileResponse|Response
    {
        $filePath = "deal-jacket-reports/{$fileName}";

        if (! Storage::exists($filePath)) {
            abort(404, 'Report not found or has expired.');
        }

        return Storage::download($filePath, $fileName);
    }
}
