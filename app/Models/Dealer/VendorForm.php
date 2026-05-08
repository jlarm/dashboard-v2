<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property int $id
 * @property int $vendor_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $signature
 * @property string|null $document_path
 * @property-read Vendor|null $vendor
 */
class VendorForm extends Model
{
    use LogsActivity, SoftDeletes;

    #[Override]
    protected $fillable = [
        'vendor_id',
        'name',
        'email',
        'signature',
        'last_notification_sent_at',
        'data',
        'document_path',
    ];

    /**
     * @return BelongsTo<Vendor, $this>
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * @return HasMany<VendorEmailLog, $this>
     */
    public function emailLogs(): HasMany
    {
        return $this->hasMany(VendorEmailLog::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logExcept(['signature', 'data']);
    }

    #[Override]
    protected function casts(): array
    {
        return [
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
    }
}
