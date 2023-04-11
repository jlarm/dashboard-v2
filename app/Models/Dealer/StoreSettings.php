<?php

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;

class StoreSettings extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'postal_code',
        'phone',
        'fax',
        'website',
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
}
