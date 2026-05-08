<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Override;
use Spatie\Image\Enums\CropPosition;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $comment
 * @property-read User|null $user
 * @property \Illuminate\Support\Carbon|null $created_at
 */
class AuditComment extends Model implements HasMedia
{
    use InteractsWithMedia;

    #[Override]
    protected $fillable = [
        'user_id',
        'auditable_id',
        'auditable_type',
        'comment',
        'image',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function audit(): MorphTo
    {
        return $this->morphTo('audit', 'audit_type', 'audit_id');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->crop(400, 400, CropPosition::Center)
            ->quality(80);

        $this->addMediaConversion('compressed')
            ->width(1920)
            ->quality(80);
    }
}
