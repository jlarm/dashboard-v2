<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class ImportEmployeesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('super-admin') ?? false;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'spreadsheet' => ['required', 'file', 'mimetypes:application/json,text/plain', 'mimes:json', 'max:10240'],
        ];
    }

    public function spreadsheet(): UploadedFile
    {
        /** @var UploadedFile $file */
        $file = $this->file('spreadsheet');

        return $file;
    }
}
