<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Data;

final readonly class ViolationsOverviewData
{
    /**
     * @param  list<array{label:string, opened:int, closed:int}>  $monthly
     * @param  list<array{label:string, opened:int, closed:int}>  $quarterly
     * @param  list<array{label:string, opened:int, closed:int}>  $yearly
     */
    public function __construct(
        public array $monthly,
        public array $quarterly,
        public array $yearly,
    ) {}

    /**
     * @return array{
     *     monthly: list<array{label:string, opened:int, closed:int}>,
     *     quarterly: list<array{label:string, opened:int, closed:int}>,
     *     yearly: list<array{label:string, opened:int, closed:int}>,
     * }
     */
    public function toArray(): array
    {
        return [
            'monthly' => $this->monthly,
            'quarterly' => $this->quarterly,
            'yearly' => $this->yearly,
        ];
    }
}
