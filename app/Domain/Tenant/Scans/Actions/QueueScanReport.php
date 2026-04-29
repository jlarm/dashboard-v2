<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Actions;

use App\Jobs\Scans\GenerateCyrismaReportJob;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class QueueScanReport
{
    public const string STATUS_READY = 'ready';
    public const string STATUS_QUEUED = 'queued';
    public const string STATUS_ALREADY_RUNNING = 'already-running';

    public const array ALLOWED_TYPES = ['executive', 'technical'];

    /**
     * @return self::STATUS_*
     */
    public function handle(Store $store, User $user, string $type): string
    {
        $pdfCacheKey = sprintf('cyrisma_report_pdf_v2_%d_%s', $store->id, $type);

        if (Cache::has($pdfCacheKey)) {
            return self::STATUS_READY;
        }

        $lockKey = 'laravel_unique_job:'.GenerateCyrismaReportJob::class.'-'.$store->id.'-'.$type;

        if (Cache::has($lockKey)) {
            return self::STATUS_ALREADY_RUNNING;
        }

        dispatch(new GenerateCyrismaReportJob($store->id, $type, $user->id));

        return self::STATUS_QUEUED;
    }
}
