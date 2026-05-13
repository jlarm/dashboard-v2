<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Dealer\Violation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Override;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property string|null $comment
 * @property bool $completed
 * @property Carbon|null $completed_date
 * @property-read User|null $user
 * @property Carbon|null $updated_at
 */
class Remediation extends Model implements HasMedia
{
    use InteractsWithMedia;

    #[Override]
    protected $fillable = [
        'violation_id',
        'user_id',
        'comment',
        'completed',
        'completed_date',
    ];

    /**
     * @return BelongsTo<Violation, $this>
     */
    public function violation(): BelongsTo
    {
        return $this->belongsTo(Violation::class);
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
        $this->addMediaConversion('thumb')
            ->format('webp')
            ->width(400)
            ->height(400);
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'completed' => 'boolean',
            'completed_date' => 'date',
        ];
    }
}
