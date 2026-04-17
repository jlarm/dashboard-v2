<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorEmailLog extends Model
{
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

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }
}
