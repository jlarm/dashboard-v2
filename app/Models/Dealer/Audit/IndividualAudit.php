<?php

declare(strict_types=1);

namespace App\Models\Dealer\Audit;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Override;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Concerns\HasUuid;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property Carbon|null $audit_date
 * @property Carbon|null $deal_jacket_date
 * @property int|null $rating
 */
class IndividualAudit extends Model implements HasMedia
{
    use HasUuid, InteractsWithMedia, LogsActivity;

    #[Override]
    protected $guarded = [];

    /**
     * @return BelongsTo<Store, $this>
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
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

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->with('children');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id')->with('parent');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    protected function getQuarterNameAttribute(): string
    {
        $month = (int) $this->audit_date->format('n');

        return match (true) {
            $month <= 3 => 'Q1',
            $month <= 6 => 'Q2',
            $month <= 9 => 'Q3',
            default => 'Q4',
        };
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'draft' => 'boolean',
            'audit_date' => 'date:Y-m-d',
            'deal_jacket_date' => 'date:Y-m-d',
        ];
    }
}
