<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

class Timeline extends Model
{
    #[Override]
    protected $fillable = [
        'phishing_campaign_id',
        'email',
        'time',
        'message',
        'details',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(PhishingCampaign::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'details' => 'array',
            'time' => 'datetime',
        ];
    }
}
