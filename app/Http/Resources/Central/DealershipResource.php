<?php

declare(strict_types=1);

namespace App\Http\Resources\Central;

use App\Models\Dealership;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

/**
 * @mixin Dealership
 */
class DealershipResource extends JsonResource
{
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'users' => $this->whenLoaded('users', fn () => $this->users->map(fn ($user): array => [
                'id' => $user->id,
                'name' => $user->name,
            ])),
            'domain' => $this->domain,
        ];
    }
}
