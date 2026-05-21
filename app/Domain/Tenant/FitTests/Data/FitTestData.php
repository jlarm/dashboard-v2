<?php

declare(strict_types=1);

namespace App\Domain\Tenant\FitTests\Data;

use App\Models\FitTestDoc;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Date;

/**
 * @implements Arrayable<string, mixed>
 */
final readonly class FitTestData implements Arrayable
{
    public function __construct(
        public int $id,
        public string $employeeName,
        public string $date,
        public string $downloadUrl,
    ) {}

    public static function fromModel(FitTestDoc $doc): self
    {
        return new self(
            id: (int) $doc->id,
            employeeName: (string) $doc->employee_name,
            date: Date::parse($doc->date)->format('M d, Y'),
            downloadUrl: route('dealer.fit-tests.download', $doc),
        );
    }

    /**
     * @return array{id: int, employee_name: string, date: string, download_url: string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'employee_name' => $this->employeeName,
            'date' => $this->date,
            'download_url' => $this->downloadUrl,
        ];
    }
}
