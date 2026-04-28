<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Vendor;

use App\Domain\Tenant\Vendor\Data\SendVendorFormData;
use Illuminate\Foundation\Http\FormRequest;

class SendVendorFormRequest extends FormRequest
{
    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ];
    }

    public function authorize(): bool
    {
        $vendor = $this->route('vendor');

        return $vendor !== null && ($this->user()?->can('update', $vendor) ?? false);
    }

    public function toData(): SendVendorFormData
    {
        /** @var array{name: string, email: string} $validated */
        $validated = $this->validated();

        return new SendVendorFormData(
            name: $validated['name'],
            email: $validated['email'],
        );
    }
}
