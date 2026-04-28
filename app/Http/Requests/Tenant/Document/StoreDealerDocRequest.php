<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Document;

use App\Models\DealerDoc;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Override;

class StoreDealerDocRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', DealerDoc::class) ?? false;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:2048'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ];
    }

    /**
     * @return array<string, string>
     */
    #[Override]
    public function messages(): array
    {
        return [
            'file.max' => 'The uploaded file is too large (max 10MB). Visit https://www.ilovepdf.com/compress_pdf to compress it.',
        ];
    }

    /**
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if (! $this->filled('url') && ! $this->hasFile('file')) {
                    $validator->errors()->add('file', 'Please provide a URL or upload a PDF.');
                }
            },
        ];
    }
}
