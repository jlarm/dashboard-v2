<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Sds;

use App\Domain\Tenant\Sds\Queries\SearchSdsRecords;
use Illuminate\Foundation\Http\FormRequest;

class IndexSdsRecordsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Sort and direction fall back to defaults via the accessors below so
     * the page stays usable when query strings are tweaked manually.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'sort' => ['nullable', 'string'],
            'direction' => ['nullable', 'string'],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function search(): string
    {
        return mb_trim((string) ($this->validated('search') ?? ''));
    }

    public function sort(): string
    {
        $sort = (string) ($this->validated('sort') ?? '');

        return in_array($sort, SearchSdsRecords::ALLOWED_SORT_FIELDS, true) ? $sort : 'name';
    }

    public function direction(): string
    {
        return $this->validated('direction') === 'desc' ? 'desc' : 'asc';
    }
}
