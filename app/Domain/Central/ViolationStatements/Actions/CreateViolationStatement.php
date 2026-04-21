<?php

declare(strict_types=1);

namespace App\Domain\Central\ViolationStatements\Actions;

use App\Domain\Central\ViolationStatements\Data\ViolationStatementData;
use App\Domain\Central\ViolationStatements\Support\ViolationStatementCache;
use App\Domain\Central\ViolationStatements\Support\ViolationStatementImageStorage;
use App\Models\ViolationStatement;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class CreateViolationStatement
{
    public function __construct(
        private readonly ViolationStatementImageStorage $storage,
        private readonly ViolationStatementCache $cache,
    ) {}

    public function handle(ViolationStatementData $data): ViolationStatement
    {
        $statement = DB::transaction(function () use ($data): ViolationStatement {
            $referenceImageUrl = $data->image instanceof UploadedFile
                ? $this->storage->store($data->image)
                : null;

            return ViolationStatement::query()->create([
                'statement' => $data->statement,
                'weight' => $data->weight,
                'categories' => array_map(fn ($category) => $category->value, $data->categories),
                'keywords' => $data->keywords ?: null,
                'reference_image_url' => $referenceImageUrl,
            ]);
        });

        $this->cache->flush();

        return $statement;
    }
}
