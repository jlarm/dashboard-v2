<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timeline extends Model
{
    protected $fillable = [
        'phishing_campaign_id',
        'email',
        'time',
        'message',
        'details',
    ];
    protected $casts = [
        'details' => 'array',
        'time' => 'datetime',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(PhishingCampaign::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
