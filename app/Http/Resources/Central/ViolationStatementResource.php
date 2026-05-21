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
    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        $categories = collect($this->categories);

        return [
            'id' => $this->id,
            'statement' => $this->statement,
            'weight' => $this->weight,
            'categories' => $categories
                ->map(static fn (ViolationStatementCategory $category): string => $category->value)
                ->all(),
            'category_labels' => $categories
                ->map(static fn (ViolationStatementCategory $category): string => $category->label())
                ->all(),
            'reference_image_url' => $this->reference_image_url,
            'keywords' => $this->keywords ?? [],
        ];
    }
}
