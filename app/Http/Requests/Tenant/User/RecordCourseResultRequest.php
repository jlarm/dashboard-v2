<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class RecordCourseResultRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User|null $target */
        $target = $this->route('user');

        return $target instanceof User && $this->user()?->can('recordCourseResult', $target);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'taken_on' => ['required', 'date', 'before_or_equal:today'],
        ];
    }

    public function takenOn(): Carbon
    {
        return Carbon::parse((string) $this->validated('taken_on'))->startOfDay();
    }
}
