<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Scans;

use App\Domain\Tenant\Scans\Data\UploadScanReportData;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use RuntimeException;

class UploadScanReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create-dealerships') === true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'scan_type' => ['required', 'string', Rule::in(['internal', 'external'])],
            'summary_type' => ['required', 'string', Rule::in(['executive', 'technical'])],
            'date' => ['nullable', 'date'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ];
    }

    public function toData(): UploadScanReportData
    {
        /** @var array{scan_type: string, summary_type: string, date?: ?string} $validated */
        $validated = $this->validated();

        $user = $this->user();
        throw_unless($user instanceof User, RuntimeException::class, 'Authenticated user required.');

        $store = $this->resolveStore();
        throw_unless($store instanceof Store, RuntimeException::class, 'Current store required.');

        return new UploadScanReportData(
            userId: (int) $user->id,
            storeId: $store->id,
            scanType: $validated['scan_type'],
            summaryType: $validated['summary_type'],
            createdAt: $validated['date'] ?? null,
            file: $this->file('file'),
        );
    }

    private function resolveStore(): ?Store
    {
        if (app()->bound('currentStoreModel')) {
            $store = resolve('currentStoreModel');
            if ($store instanceof Store) {
                return $store;
            }
        }

        if (app()->bound('currentStore')) {
            $storeId = resolve('currentStore');
            if (is_numeric($storeId)) {
                return Store::query()->find((int) $storeId);
            }
        }

        return Store::query()->orderBy('id')->first();
    }
}
