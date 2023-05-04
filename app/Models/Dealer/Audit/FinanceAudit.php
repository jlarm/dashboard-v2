<?php

namespace App\Models\Dealer\Audit;

use App\Models\Dealer\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FinanceAudit extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'draft' => 'boolean',
        'audit_date' => 'date:Y-m-d',
        'finance_q1_danger' => 'boolean',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {

        $this
            ->addMediaConversion('preview')
            ->withResponsiveImages()
            ->quality(50)
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->optimize()
            ->queued();
    }

    public function getPathToMedia(Media $media): string
    {
        return tenant('id') . '/' . $media->collection_name . '/' . $media->id . '/';
    }
}
