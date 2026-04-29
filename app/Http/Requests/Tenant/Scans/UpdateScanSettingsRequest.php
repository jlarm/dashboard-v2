<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Scans;

use App\Domain\Tenant\Scans\Data\UpdateScanSettingsData;
use App\Models\Dealer\Cyrisma;
use App\Models\Dealer\Store;
use Illuminate\Foundation\Http\FormRequest;
use RuntimeException;

class UpdateScanSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        $store = $this->resolveStore();

        if (! $store instanceof Store) {
            return false;
        }

        if ($store->cyrisma instanceof Cyrisma) {
            return $this->user()?->can('update', $store->cyrisma) === true;
        }

        return $this->user()?->can('create', Cyrisma::class) === true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'instance_id' => ['required', 'string', 'min:3', 'max:255'],
        ];
    }

    public function toData(): UpdateScanSettingsData
    {
        $store = $this->resolveStore();

        throw_unless($store instanceof Store, RuntimeException::class, 'Current store is required.');

        /** @var array{instance_id: string} $validated */
        $validated = $this->validated();

        return new UpdateScanSettingsData(
            storeId: $store->id,
            instanceId: mb_trim($validated['instance_id']),
        );
    }

    private function resolveStore(): ?Store
    {
        if (app()->bound('currentStoreModel')) {
            $store = resolve('currentStoreModel');

            return $store instanceof Store ? $store : null;
        }

        if (app()->bound('currentStore')) {
            $storeId = resolve('currentStore');

            if (is_numeric($storeId)) {
                return Store::query()->find((int) $storeId);
            }
        }

        return null;
    }
}
