<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Vendor;

use App\Domain\Tenant\Vendor\Data\CreateVendorData;
use App\Models\Dealer\Vendor;
use Illuminate\Foundation\Http\FormRequest;

class StoreVendorRequest extends FormRequest
{
    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:vendors,name'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'store_id' => ['nullable', 'integer', 'exists:stores,id'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->can('create', Vendor::class) ?? false;
    }

    public function toData(): CreateVendorData
    {
        /** @var array{name: string, contact_name: string, contact_email: string, store_id?: int|null} $validated */
        $validated = $this->validated();

        return new CreateVendorData(
            name: $validated['name'],
            contactName: $validated['contact_name'],
            contactEmail: $validated['contact_email'],
            storeId: $validated['store_id'] ?? null,
        );
    }
}
