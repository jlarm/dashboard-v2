<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Store;

use App\Domain\Tenant\Store\Data\UpdateStoreData;
use App\Enums\State;
use App\Models\Dealer\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', Store::class) ?? false;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        /** @var Store $store */
        $store = $this->route('store');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9 ]+$/',
                Rule::unique('stores', 'name')->ignore($store->id),
            ],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', Rule::enum(State::class)],
            'postal_code' => ['required', 'string', 'max:20'],
            'phone' => ['required', 'string', 'max:50'],
            'website' => ['required', 'string', 'max:255'],
        ];
    }

    public function toData(): UpdateStoreData
    {
        /** @var array{name: string, address: string, city: string, state: string, postal_code: string, phone: string, website: string} $validated */
        $validated = $this->validated();

        return new UpdateStoreData(
            name: $validated['name'],
            address: $validated['address'],
            city: $validated['city'],
            state: State::from($validated['state']),
            postalCode: $validated['postal_code'],
            phone: $validated['phone'],
            website: $validated['website'],
        );
    }
}
