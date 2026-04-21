<?php

declare(strict_types=1);

namespace App\Domain\Central\ViolationStatements\Support;

use App\Enums\ViolationStatementCategory;
use Illuminate\Support\Facades\Cache;

class ViolationStatementCache
{
    public function flush(): void
    {
        foreach (ViolationStatementCategory::cases() as $category) {
            Cache::forget('violation_statements.'.$category->value);
        }
    }
}
