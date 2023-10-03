<?php

namespace App\Models\Dealer;

use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Settings\EmployeeList;
use App\Models\DealerDoc;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Store extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'address',
        'city',
        'state',
        'postal_code',
        'phone',
        'website',
        'logo',
        'note',
        'active_monitoring',
        'monitoring_start_date',
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
        'monitoring_start_date' => 'date:Y-m-d',
        'currently_monitoring' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getPhoneNumberAttribute(): string
    {
        $cleaned = preg_replace('/[^[:digit:]]/', '', $this->phone);
        preg_match('/(\d{3})(\d{3})(\d{4})/', $cleaned, $matches);

        return "({$matches[1]}) {$matches[2]}-{$matches[3]}";
    }

    public function users(): BelongsToMany
    {
        return $this->BelongsToMany(User::class);
    }

    public function dealerInfo(): HasOne
    {
        return $this->hasOne(DealerInfo::class);
    }

    public function storeSettings(): HasOne
    {
        return $this->hasOne(StoreSettings::class);
    }

    public function scanSetting(): HasOne
    {
        return $this->hasOne(ScanSetting::class);
    }

    public function oshaAudits(): HasMany
    {
        return $this->hasMany(OshaAudit::class);
    }

    public function bodyShopAudits(): HasMany
    {
        return $this->hasMany(BodyShopAudit::class);
    }

    public function financeAudits(): HasMany
    {
        return $this->hasMany(FinanceAudit::class);
    }

    public function individualAudits(): HasMany
    {
        return $this->hasMany(IndividualAudit::class);
    }

    public function employeeList(): HasOne
    {
        return $this->hasOne(EmployeeList::class);
    }

    public function isps(): HasMany
    {
        return $this->hasMany(Isp::class);
    }

    public function oshas(): HasMany
    {
        return $this->hasMany(Osha::class);
    }

    public function redflags(): HasMany

    {
        return $this->hasMany(RedFlag::class);
    }

    public function scanReports(): HasMany
    {
        return $this->hasMany(ScanReport::class);
    }

    public function docs(): HasMany
    {
        return $this->hasMany(DealerDoc::class);
    }
}
