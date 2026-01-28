<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use App\Models\Remediation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Violation extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'model_type',
        'model_id',
        'uuid',
        'statement_id',
        'statement',
        'comment',
        'violation_date',
        'risk',
    ];
    protected $casts = [
        'violation_date' => 'date:Y-m-d',
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->crop('crop-center', 400, 400)
            ->quality(80)
            ->width(202)
            ->height(150);

        $this->addMediaConversion('audit-view')
            ->fit('max', 1500, 1500)
            ->quality(80);

    }

    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    public function remediation(): HasOne
    {
        return $this->hasOne(Remediation::class);
    }
}
