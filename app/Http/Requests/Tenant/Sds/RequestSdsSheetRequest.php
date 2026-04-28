<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Sds;

use App\Domain\Tenant\Sds\Data\RequestSdsSheetData;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use RuntimeException;

class RequestSdsSheetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function toData(): RequestSdsSheetData
    {
        /** @var array{name: string, manufacturer?: string|null} $validated */
        $validated = $this->validated();

        $manufacturer = isset($validated['manufacturer']) ? mb_trim($validated['manufacturer']) : '';

        $user = $this->user();

        throw_unless($user instanceof User, RuntimeException::class, 'Authenticated user required.');

        return new RequestSdsSheetData(
            chemicalName: $validated['name'],
            manufacturer: $manufacturer === '' ? null : $manufacturer,
            requesterName: (string) $user->name,
            requesterEmail: (string) $user->email,
        );
    }
}
