<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Audits;

use Illuminate\Foundation\Http\FormRequest;

class UpdateViolationAuditRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'violations' => ['required', 'array'],
            'violations.*.id' => ['required', 'integer'],
            'violations.*.comment' => ['nullable', 'string'],
            'violations.*.violation_date' => ['nullable', 'date'],
            'violations.*.risk' => ['nullable', 'boolean'],
            'violations.*.severity' => ['nullable', 'integer', 'min:0', 'max:10'],
            'violations.*.show_reference_image' => ['nullable', 'boolean'],
            'violations.*.images' => ['nullable', 'array', 'max:3'],
            'violations.*.images.*' => ['file', 'mimes:jpg,jpeg,png,webp,heic,heif', 'max:10240'],
        ];
    }

    /**
     * @return array{date: string, violations: array<int, array{id: int, comment: string, violation_date: ?string, risk: bool, severity: ?int, show_reference_image: bool, images?: array<array-key, mixed>}>}
     */
    public function toData(): array
    {
        /** @var array<string, mixed> $validated */
        $validated = $this->validated();

        $violations = collect((array) ($validated['violations'] ?? []))
            ->map(static fn (array $violation): array => [
                'id' => (int) $violation['id'],
                'comment' => (string) ($violation['comment'] ?? ''),
                'violation_date' => $violation['violation_date'] ?? null,
                'risk' => (bool) ($violation['risk'] ?? false),
                'severity' => isset($violation['severity']) ? (int) $violation['severity'] : null,
                'show_reference_image' => (bool) ($violation['show_reference_image'] ?? false),
                'images' => $violation['images'] ?? [],
            ])
            ->all();

        return [
            'date' => (string) $validated['date'],
            'violations' => $violations,
        ];
    }
}
