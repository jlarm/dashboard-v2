<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class VendorForm extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'vendor_id',
        'name',
        'email',
        'signature',
        'last_notification_sent_at',
        'data',
        'document_path',
    ];
    protected $casts = [
        'id' => 'integer',
        'vendor_id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'signature' => 'string',
        'last_notification_sent_at' => 'datetime',
        'data' => 'array',
        'document_path' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function emailLogs(): HasMany
    {
        return $this->hasMany(VendorEmailLog::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }
}
