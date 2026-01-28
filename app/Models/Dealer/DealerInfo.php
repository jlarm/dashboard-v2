<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DealerInfo extends Model
{
    protected $fillable = [
        'store_id',
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
        'ip_addresses' => AsCollection::class,
        'website_urls' => AsCollection::class,
    ];

    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
