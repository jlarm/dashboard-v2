<?php

declare(strict_types=1);

namespace App\Http\Resources\Tenant;

use App\Domain\Tenant\User\Data\EmployeeData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

/**
 * @property EmployeeData $resource
 */
class EmployeeResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return $this->resource->toArray();
    }
}
