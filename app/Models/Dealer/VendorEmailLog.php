<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Override;

/**
 * @property int $id
 * @property string|null $event_type
 * @property string|null $delivery_message
 * @property Carbon|null $sent_at
 * @property Carbon|null $delivered_at
 */
class VendorEmailLog extends Model
{
    #[Override]
    protected $fillable = [
        'vendor_form_id',
        'to',
        'subject',
        'mailgun_id',
        'mailgun_message',
        'message_id',
        'sent_at',
        'status',
        'delivered_at',
        'delivery_message',
        'event_type',
    ];

    public function vendorForm(): BelongsTo
    {
        return $this->belongsTo(VendorForm::class);
    }

    protected function scopeRecentSuccessfulFor(Builder $query, int $vendorFormId, int $minutes): Builder
    {
        return $query
            ->where('vendor_form_id', $vendorFormId)
            ->whereNotNull('message_id')
            ->where('sent_at', '>=', now()->subMinutes($minutes));
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }
}
