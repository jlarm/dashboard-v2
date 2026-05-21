<?php

declare(strict_types=1);

namespace App\Domain\Tenant\FitTests\Queries;

use App\Domain\Tenant\FitTests\Data\FitTestData;
use App\Models\Dealer\Store;
use App\Models\FitTestDoc;

class GetFitTests
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function handle(Store $store): array
    {
        return $store->fitTests()
            ->oldest()
            ->orderBy('employee_name')
            ->get()
            ->map(static fn (FitTestDoc $doc): array => FitTestData::fromModel($doc)->toArray())
            ->all();
    }
}
