<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Store;

use App\Domain\Tenant\Store\Data\CreateStoreData;
use App\Enums\State;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateStoreRequest extends FormRequest
{
    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:stores,name', 'regex:/^[a-zA-Z0-9 ]+$/'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', Rule::enum(State::class)],
            'postal_code' => ['required', 'string', 'max:20'],
            'phone' => ['required', 'string', 'max:50'],
            'website' => ['required', 'string', 'max:255'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(['super-admin', 'Consultant']) ?? false;
    }

    public function toData(): CreateStoreData
    {
        /** @var array{name: string, address: string, city: string, state: string, postal_code: string, phone: string, website: string} $validated */
        $validated = $this->validated();

        return new CreateStoreData(
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
