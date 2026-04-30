<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Actions;

use App\Models\Dealer\Violation;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DeleteViolationPhoto
{
    public function handle(Violation $violation, int $mediaId): void
    {
        $media = $violation->media()->whereKey($mediaId)->first();

        if ($media instanceof Media) {
            $media->delete();
        }
    }
}
