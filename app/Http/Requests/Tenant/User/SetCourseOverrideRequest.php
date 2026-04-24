<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SetCourseOverrideRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User|null $target */
        $target = $this->route('user');

        return $target instanceof User && $this->user()?->can('manageCourses', $target);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'state' => ['required', Rule::in(['default', 'add', 'exclude'])],
        ];
    }

    public function state(): string
    {
        return (string) $this->validated('state');
    }
}
