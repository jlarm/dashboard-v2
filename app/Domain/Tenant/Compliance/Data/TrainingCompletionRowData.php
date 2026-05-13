<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Data;

final readonly class TrainingCompletionRowData
{
    public function __construct(
        public string $label,
        public int $value,
        public int $headcount,
    ) {}

    /**
     * @return array{label:string, value:int, headcount:int}
     */
    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'value' => $this->value,
            'headcount' => $this->headcount,
        ];
    }
}
