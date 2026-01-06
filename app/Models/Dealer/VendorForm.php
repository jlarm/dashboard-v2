<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorForm extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'name',
        'email',
        'signature',
        'last_notification_sent_at',
        'data',
    ];
    protected $casts = [
        'data' => 'array',
        'last_notification_sent_at' => 'datetime',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function emailLogs(): HasMany
    {
        return $this->hasMany(VendorEmailLog::class);
    }
}
