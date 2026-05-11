<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\IndividualAudits;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class UpdateIndividualAuditRequest extends FormRequest
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
        $rules = [
            'draft' => ['nullable', 'boolean'],
            'audit_date' => ['nullable', 'date'],
            'deal_jacket_date' => ['nullable', 'date'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'customer_number' => ['nullable', 'string', 'max:255'],
            'manager_id' => ['nullable', 'integer', 'exists:users,id'],
            'mileage' => ['nullable', 'string', 'max:50'],
            'answers' => ['nullable', 'array'],
            'new_images' => ['nullable', 'array', 'max:20'],
            'new_images.*' => ['file', 'mimes:jpg,jpeg,png,webp,heic,heif', 'max:10240'],
            'remove_image_ids' => ['nullable', 'array'],
            'remove_image_ids.*' => ['integer'],
        ];

        for ($i = 1; $i <= 40; $i++) {
            $rules["answers.{$i}.answer"] = ['nullable', 'string', 'max:10'];
            $rules["answers.{$i}.comment"] = ['nullable', 'string'];
            $rules["answers.{$i}.danger"] = ['nullable', 'boolean'];
        }

        return $rules;
    }

    /**
     * @return array{
     *   draft: bool,
     *   audit_date: ?string,
     *   deal_jacket_date: ?string,
     *   customer_name: ?string,
     *   customer_number: ?string,
     *   manager_id: ?int,
     *   mileage: ?string,
     *   answers: array<int, array{answer: ?string, comment: ?string, danger: bool}>,
     *   new_images: array<int, UploadedFile>,
     *   remove_image_ids: array<int, int>,
     * }
     */
    public function toData(): array
    {
        /** @var array<string, mixed> $validated */
        $validated = $this->validated();

        $answers = [];
        for ($i = 1; $i <= 40; $i++) {
            $row = $validated['answers'][$i] ?? [];
            $answers[$i] = [
                'answer' => isset($row['answer']) ? (string) $row['answer'] : null,
                'comment' => isset($row['comment']) ? (string) $row['comment'] : null,
                'danger' => (bool) ($row['danger'] ?? false),
            ];
        }

        /** @var array<int, UploadedFile> $newImages */
        $newImages = (array) ($this->file('new_images') ?? []);

        return [
            'draft' => (bool) ($validated['draft'] ?? true),
            'audit_date' => isset($validated['audit_date']) ? (string) $validated['audit_date'] : null,
            'deal_jacket_date' => isset($validated['deal_jacket_date']) ? (string) $validated['deal_jacket_date'] : null,
            'customer_name' => isset($validated['customer_name']) ? (string) $validated['customer_name'] : null,
            'customer_number' => isset($validated['customer_number']) ? (string) $validated['customer_number'] : null,
            'manager_id' => isset($validated['manager_id']) ? (int) $validated['manager_id'] : null,
            'mileage' => isset($validated['mileage']) ? (string) $validated['mileage'] : null,
            'answers' => $answers,
            'new_images' => $newImages,
            'remove_image_ids' => array_map('intval', $validated['remove_image_ids'] ?? []),
        ];
    }
}
