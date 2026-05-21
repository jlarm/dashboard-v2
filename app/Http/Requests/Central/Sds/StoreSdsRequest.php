<?php

declare(strict_types=1);

namespace App\Http\Requests\Central\Sds;

use App\Models\Sds;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Validator;
use Override;

class StoreSdsRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'keywords' => ['nullable', 'array'],
            'keywords.*' => ['string', 'max:255'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'file.max' => 'The uploaded file is too large (max 5MB). Please compress the PDF before uploading.',
        ];
    }

    /**
     * @return array<int, Closure>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $file = $this->file('file');

                if (! $file instanceof UploadedFile) {
                    return;
                }

                $fileName = str_replace(' ', '-', $file->getClientOriginalName());

                if (Sds::query()->where('file_name', $fileName)->exists()) {
                    $validator->errors()->add('file', 'A file with the same name already exists.');
                }
            },
        ];
    }
}
