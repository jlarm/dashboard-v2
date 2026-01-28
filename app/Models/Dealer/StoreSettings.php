<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class StoreSettings extends Model
{
    use LogsActivity;

    protected $fillable = [
        'store_id',
        'name',
        'address',
        'city',
        'state',
        'postal_code',
        'phone',
        'fax',
        'website',
        'logo',
        'police_emergency_phone',
        'police_non_emergency_phone',
        'fire_emergency_phone',
        'fire_non_emergency_phone',
        'fire_alarm_type',
        'burglar_alarm_type',
        'firewall_company',
        'ip_addresses',
        'mfa',
        'vulnerability',
        'currently_monitoring',
        'antivirus_software',
        'antivirus_computers',
        'antivirus_minutes',
        'screensaver_minutes',
        'dms_provider',
        'website_urls',
        'backups',
        'designated_red_flag_coordinator',
        'document_shredding',
        'service_provider_agreements',
        'offsite_storage',
        'other_business',
        'vendor_access',
        'personal_devices',
        'compliance_issues',
    ];
    protected $casts = [
        'ip_addresses' => 'array',
        'website_urls' => 'array',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }
}
