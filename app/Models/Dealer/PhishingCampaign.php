<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Override;

class PhishingCampaign extends Model
{
    #[Override]
    protected $fillable = [
        'campaign_id',
        'user_id',
        'store_id',
        'name',
        'status',
        'results',
        'launched_at',
        'campaign_created_at',
        'emails_sent',
        'emails_opened',
        'links_clicked',
        'data_submitted',
        'emails_reported',
    ];

    /**
     * @return HasMany<Timeline, $this>
     */
    public function timelines(): HasMany
    {
        return $this->hasMany(Timeline::class);
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'results' => 'array',
            'launched_at' => 'datetime',
            'campaign_created_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Store, $this>
     */
    protected function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
