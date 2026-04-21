<?php

declare(strict_types=1);

namespace App\Http\Resources\Central;

use App\Enums\ViolationStatementCategory;
use App\Models\ViolationStatement;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

/**
 * @mixin ViolationStatement
 */
class ViolationStatementResource extends JsonResource
{
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'statement' => $this->statement,
            'weight' => $this->weight,
            'categories' => $this->categories,
            'category_labels' => array_map(
                fn (string $value): string => ViolationStatementCategory::from($value)->label(),
                $this->categories,
            ),
            'reference_image_url' => $this->reference_image_url,
            'keywords' => $this->keywords ?? [],
        ];
    }
}
