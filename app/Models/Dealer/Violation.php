<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use App\Models\BodyShopViolationStatement;
use App\Models\GlbaViolationStatements;
use App\Models\OshaViolationStatements;
use App\Models\Remediation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Override;
use Spatie\Image\Enums\CropPosition;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property string|null $uuid
 * @property int|null $statement_id
 * @property string|null $statement
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $violation_date
 * @property bool $risk
 * @property int|null $severity
 * @property bool $show_reference_image
 * @property-read Remediation|null $remediation
 */
class Violation extends Model implements HasMedia
{
    use InteractsWithMedia;

    #[Override]
    protected $fillable = [
        'model_type',
        'model_id',
        'uuid',
        'statement_id',
        'statement',
        'comment',
        'violation_date',
        'risk',
        'severity',
        'show_reference_image',
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->crop(400, 400, CropPosition::Center)
            ->quality(80)
            ->width(202)
            ->height(150);

        $this->addMediaConversion('audit-view')
            ->fit(Fit::Max, 1500, 1500)
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

    public function oshaStatement(): BelongsTo
    {
        return $this->belongsTo(OshaViolationStatements::class, 'statement_id');
    }

    public function bodyShopStatement(): BelongsTo
    {
        return $this->belongsTo(BodyShopViolationStatement::class, 'statement_id');
    }

    public function glbaStatement(): BelongsTo
    {
        return $this->belongsTo(GlbaViolationStatements::class, 'statement_id');
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'uuid' => 'string',
            'statement_id' => 'integer',
            'statement' => 'string',
            'text' => 'string',
            'date' => 'date',
            'violation_date' => 'date:Y-m-d',
            'risk' => 'boolean',
            'severity' => 'integer',
            'show_reference_image' => 'boolean',
        ];
    }
}
