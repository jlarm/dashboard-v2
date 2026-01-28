<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Dealer\Violation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Remediation extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'violation_id',
        'user_id',
        'comment',
        'completed',
        'completed_date',
    ];
    protected $casts = [
        'completed' => 'boolean',
        'completed_date' => 'date',
    ];

    public function violation(): BelongsTo
    {
        return $this->belongsTo(Violation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->format(Manipulations::FORMAT_WEBP)
            ->width(400)
            ->height(400);
    }
}
