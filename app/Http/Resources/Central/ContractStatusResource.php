<?php

declare(strict_types=1);

namespace App\Http\Resources\Central;

use App\Models\ContractStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

/**
 * @mixin ContractStatus
 */
class ContractStatusResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'step' => $this->step,
            'created_at' => $this->created_at?->toIso8601String(),
            'created_at_for_humans' => $this->created_at?->diffForHumans(),
        ];
    }
}
