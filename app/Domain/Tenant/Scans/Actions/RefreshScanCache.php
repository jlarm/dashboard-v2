<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Actions;

use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Exception;
use Illuminate\Support\Facades\Log;

class RefreshScanCache
{
    public function __construct(private readonly CyrismaService $cyrisma) {}

    public function handle(Store $store): void
    {
        try {
            $this->cyrisma->forStore($store)->clearCache();
        } catch (Exception $e) {
            Log::error('Failed to clear Cyrisma cache', [
                'store_id' => $store->id,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
