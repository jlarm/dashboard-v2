<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Actions;

use App\Domain\Tenant\Scans\Data\UploadScanReportData;
use App\Models\Dealer\ScanReport;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;

class UploadScanReport
{
    public function handle(UploadScanReportData $data): ScanReport
    {
        $path = Storage::disk('do-scans')
            ->putFileAs((string) tenant('id'), $data->file, $data->file->getClientOriginalName());

        $payload = [
            'user_id' => $data->userId,
            'store_id' => $data->storeId,
            'path' => $path,
            'scan_type' => mb_strtolower($data->scanType),
            'type' => mb_strtolower($data->summaryType),
        ];

        if ($data->createdAt !== null && $data->createdAt !== '') {
            $customDate = Date::parse($data->createdAt)->startOfDay();
            $payload['created_at'] = $customDate;
            $payload['updated_at'] = $customDate;
        }

        return ScanReport::query()->create($payload);
    }
}
