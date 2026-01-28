<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhishingCampaign extends Model
{
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
    protected $casts = [
        'results' => 'array',
        'launched_at' => 'datetime',
        'campaign_created_at' => 'datetime',
    ];

    public function timelines(): HasMany
    {
        return $this->hasMany(Timeline::class);
    }

    protected function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
