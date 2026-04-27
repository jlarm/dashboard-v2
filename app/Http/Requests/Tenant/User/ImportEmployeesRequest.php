<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\User;

use App\Enums\Role;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class ImportEmployeesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole(Role::SuperAdmin->value) ?? false;
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

    /**
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $file = $this->file('spreadsheet');

                if (! $file instanceof UploadedFile) {
                    return;
                }

                $payload = json_decode((string) file_get_contents((string) $file->getRealPath()), true);

                if (! is_array($payload) || ! isset($payload['employees']) || ! is_array($payload['employees'])) {
                    $validator->errors()->add(
                        'spreadsheet',
                        'The file must be a JSON object containing an "employees" array.',
                    );
                }
            },
        ];
    }

    public function spreadsheet(): UploadedFile
    {
        /** @var UploadedFile $file */
        $file = $this->file('spreadsheet');

        return $file;
    }
}
