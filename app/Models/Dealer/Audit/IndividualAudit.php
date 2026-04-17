<?php

declare(strict_types=1);

namespace App\Models\Dealer\Audit;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Concerns\HasUuid;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class IndividualAudit extends Model implements HasMedia
{
    use HasUuid, InteractsWithMedia, LogsActivity;

    protected $guarded = [];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        /** @phpstan-ignore-next-line */
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function getQuarterNameAttribute(): string
    {
        $month = (int) $this->audit_date->format('n');

        return match (true) {
            $month <= 3 => 'Q1',
            $month <= 6 => 'Q2',
            $month <= 9 => 'Q3',
            default => 'Q4',
        };
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    protected function casts(): array
    {
        return [
            'draft' => 'boolean',
            'audit_date' => 'date:Y-m-d',
            'deal_jacket_date' => 'date:Y-m-d',
        ];
    }
}
