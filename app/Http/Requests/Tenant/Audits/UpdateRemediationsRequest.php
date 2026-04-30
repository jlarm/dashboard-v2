<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Audits;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRemediationsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'remediations' => ['required', 'array'],
            'remediations.*.comment' => ['nullable', 'string'],
            'remediations.*.completed' => ['nullable', 'boolean'],
            'remediations.*.photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,heic,heif', 'max:10240'],
            'remediations.*.remove_photo' => ['nullable', 'boolean'],
        ];
    }

    /**
     * @return array<int, array{comment: string, completed: bool, photo: ?\Illuminate\Http\UploadedFile, remove_photo: bool}>
     */
    public function toData(): array
    {
        /** @var array{remediations: array<int|string, array<string, mixed>>} $validated */
        $validated = $this->validated();

        $result = [];
        foreach ($validated['remediations'] as $violationId => $payload) {
            $result[(int) $violationId] = [
                'comment' => (string) ($payload['comment'] ?? ''),
                'completed' => (bool) ($payload['completed'] ?? false),
                'photo' => $payload['photo'] ?? null,
                'remove_photo' => (bool) ($payload['remove_photo'] ?? false),
            ];
        }

        return $result;
    }
}
