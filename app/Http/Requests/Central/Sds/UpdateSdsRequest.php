<?php

declare(strict_types=1);

namespace App\Http\Requests\Central\Sds;

use App\Models\Sds;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Validator;
use Override;

class UpdateSdsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'keywords' => ['nullable', 'array'],
            'keywords.*' => ['string', 'max:255'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'file.max' => 'The uploaded file is too large (max 5MB). Please compress the PDF before uploading.',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $file = $this->file('file');

                if (! $file instanceof UploadedFile) {
                    return;
                }

                /** @var Sds $sds */
                $sds = $this->route('sds');
                $fileName = str_replace(' ', '-', $file->getClientOriginalName());

                $exists = Sds::query()
                    ->where('file_name', $fileName)
                    ->where('id', '!=', $sds->id)
                    ->exists();

                if ($exists) {
                    $validator->errors()->add('file', 'A file with the same name already exists.');
                }
            },
        ];
    }
}
