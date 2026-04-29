<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Scans;

use App\Domain\Tenant\Scans\Actions\QueueScanReport;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QueueScanReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', Rule::in(QueueScanReport::ALLOWED_TYPES)],
        ];
    }

    public function reportType(): string
    {
        /** @var array{type: string} $validated */
        $validated = $this->validated();

        return $validated['type'];
    }
}
