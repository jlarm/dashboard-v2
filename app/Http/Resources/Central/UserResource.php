<?php

declare(strict_types=1);

namespace App\Http\Resources\Central;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

class UserResource extends JsonResource
{
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
        ];
    }
}
