<?php

declare(strict_types=1);

namespace App\Http\Resources\Central;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

/**
 * @mixin User
 */
class UserResource extends JsonResource
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
            'slug' => $this->slug,
            'email' => $this->email,
            'role' => $this->primaryRoleName(),
            'completed_courses_count' => $this->when(
                isset($this->completed_courses_count),
                fn (): int => (int) $this->completed_courses_count,
            ),
            'last_login_at' => $this->last_login_at?->toIso8601String(),
        ];
    }
}
