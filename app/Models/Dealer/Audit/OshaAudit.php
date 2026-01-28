<?php

declare(strict_types=1);

namespace App\Models\Dealer\Audit;

use App\Models\AuditComment;
use App\Models\Dealer\Store;
use App\Models\Dealer\Violation;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class OshaAudit extends Model implements HasMedia
{
    use InteractsWithMedia, LogsActivity;

    protected $guarded = [];
    protected $casts = [
        'draft' => 'boolean',
        'audit_date' => 'date:Y-m-d',
        'osha_q64_date' => 'date:Y-m-d',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function violations(): MorphMany
    {
        return $this->morphMany(Violation::class, 'violationable');
    }

    public function auditComments(): MorphMany
    {
        return $this->morphMany(AuditComment::class, 'auditable');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    public function getPathToMedia(Media $media): string
    {
        return tenant('id').'/'.$media->collection_name.'/'.$media->id.'/';
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }
}
