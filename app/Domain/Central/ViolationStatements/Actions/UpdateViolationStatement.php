<?php

declare(strict_types=1);

namespace App\Domain\Central\ViolationStatements\Actions;

use App\Domain\Central\ViolationStatements\Data\ViolationStatementData;
use App\Domain\Central\ViolationStatements\Support\ViolationStatementCache;
use App\Domain\Central\ViolationStatements\Support\ViolationStatementImageStorage;
use App\Models\ViolationStatement;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class UpdateViolationStatement
{
    public function __construct(
        private readonly ViolationStatementImageStorage $storage,
        private readonly ViolationStatementCache $cache,
    ) {}

    public function handle(ViolationStatement $violationStatement, ViolationStatementData $data, bool $removeImage = false): ViolationStatement
    {
        $statement = DB::transaction(function () use ($violationStatement, $data, $removeImage): ViolationStatement {
            $referenceImageUrl = $violationStatement->reference_image_url;

            if ($data->image instanceof UploadedFile) {
                $this->storage->delete($referenceImageUrl);
                $referenceImageUrl = $this->storage->store($data->image);
            } elseif ($removeImage) {
                $this->storage->delete($referenceImageUrl);
                $referenceImageUrl = null;
            }

            $violationStatement->update([
                'statement' => $data->statement,
                'weight' => $data->weight,
                'categories' => array_map(fn ($category) => $category->value, $data->categories),
                'keywords' => $data->keywords ?: null,
                'reference_image_url' => $referenceImageUrl,
            ]);

            return $violationStatement->fresh() ?? $violationStatement;
        });

        $this->cache->flush();

        return $statement;
    }
}
