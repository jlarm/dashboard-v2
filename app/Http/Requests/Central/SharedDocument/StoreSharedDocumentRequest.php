<?php

declare(strict_types=1);

namespace App\Http\Requests\Central\SharedDocument;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Override;

class StoreSharedDocumentRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:2048'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar', 'max:10240'],
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'file.max' => 'The uploaded file is too large (max 10MB). Please compress it before uploading.',
        ];
    }

    /**
     * @return array<int, Closure>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if (! $this->filled('url') && ! $this->hasFile('file')) {
                    $validator->errors()->add('file', 'Please provide a URL or upload a file.');
                }
            },
        ];
    }
}
