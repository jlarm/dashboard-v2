<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Audit;

use App\Domain\Tenant\FitTests\Data\CreateFitTestData;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Override;

class StoreFitTestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create-dealerships') ?? false;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'date' => ['required', 'date'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ];
    }

    /**
     * @return array<string, string>
     */
    #[Override]
    public function messages(): array
    {
        return [
            'user_id.required' => 'Please select an employee.',
            'file.required' => 'Please upload a file.',
            'file.max' => 'The uploaded file is too large (max 2MB).',
        ];
    }

    public function toData(): CreateFitTestData
    {
        $userId = (int) $this->validated('user_id');
        $file = $this->file('file');

        abort_unless($file instanceof UploadedFile, 422);

        return new CreateFitTestData(
            userId: $userId,
            employeeName: (string) User::query()->whereKey($userId)->value('name'),
            date: (string) $this->validated('date'),
            file: $file,
        );
    }
}
