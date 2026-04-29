<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Actions;

use App\Domain\Tenant\Scans\Data\UpdateScanSettingsData;
use App\Models\Dealer\Cyrisma;
use App\Services\CyrismaService;
use Illuminate\Validation\ValidationException;

class UpdateScanSettings
{
    public function __construct(private readonly CyrismaService $cyrisma) {}

    public function handle(UpdateScanSettingsData $data): Cyrisma
    {
        $instances = $this->cyrisma->getAllInstances() ?? [];
        $instanceUrl = $data->instanceId.'.cyrisma.com';
        $instance = collect($instances)->firstWhere('url', $instanceUrl);

        if ($instance === null) {
            throw ValidationException::withMessages([
                'instance_id' => 'No Cyrisma instance was found with that ID.',
            ]);
        }

        return Cyrisma::query()->updateOrCreate(
            ['store_id' => $data->storeId],
            [
                'short_name' => $instance['short_name'] ?? '',
                'instance_id' => $instance['instance_id'],
                'instance_url' => $instance['url'],
            ],
        );
    }
}
