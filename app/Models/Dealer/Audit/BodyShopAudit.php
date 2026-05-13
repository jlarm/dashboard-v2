<?php

declare(strict_types=1);

namespace App\Models\Dealer\Audit;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Override;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property Carbon|null $audit_date
 * @property string|null $name
 * @property-read Store|null $store
 */
class BodyShopAudit extends Model implements HasMedia
{
    use InteractsWithMedia, LogsActivity;

    #[Override]
    protected $guarded = [];

    /**
     * @return BelongsTo<Store, $this>
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->nonQueued()
            ->fit(Fit::Crop, 300, 300);
    }

    public function getPathToMedia(Media $media): string
    {
        return tenant('id').'/'.$media->collection_name.'/'.$media->id.'/';
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'draft' => 'boolean',
            'audit_date' => 'date:Y-m-d',
            'body_shop_q16_inspection_date' => 'date:Y-m-d',
        ];
    }
}
