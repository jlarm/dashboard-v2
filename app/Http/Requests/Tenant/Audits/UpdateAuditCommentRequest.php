<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Audits;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class UpdateAuditCommentRequest extends FormRequest
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
            'comment' => ['required', 'string'],
            'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,heic,heif', 'max:10240'],
            'remove_photo' => ['nullable', 'boolean'],
        ];
    }

    public function commentBody(): string
    {
        /** @var array{comment: string} $validated */
        $validated = $this->validated();

        return $validated['comment'];
    }

    public function photo(): ?UploadedFile
    {
        $photo = $this->file('photo');

        return $photo instanceof UploadedFile ? $photo : null;
    }

    public function removePhoto(): bool
    {
        return (bool) $this->boolean('remove_photo');
    }
}
