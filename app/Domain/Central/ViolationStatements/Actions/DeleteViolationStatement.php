<?php

declare(strict_types=1);

namespace App\Domain\Central\ViolationStatements\Actions;

use App\Domain\Central\ViolationStatements\Support\ViolationStatementCache;
use App\Domain\Central\ViolationStatements\Support\ViolationStatementImageStorage;
use App\Models\ViolationStatement;
use Illuminate\Support\Facades\DB;

class DeleteViolationStatement
{
    public function __construct(
        private readonly ViolationStatementImageStorage $storage,
        private readonly ViolationStatementCache $cache,
    ) {}

    public function handle(ViolationStatement $violationStatement): void
    {
        DB::transaction(function () use ($violationStatement): void {
            $this->storage->delete($violationStatement->reference_image_url);

            $violationStatement->delete();
        });

        $this->cache->flush();
    }
}
