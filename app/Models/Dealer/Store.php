<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use App\Enums\Frequency;
use App\Models\CmsManual;
use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Settings\EmployeeList;
use App\Models\DealerDoc;
use App\Models\FitTestDoc;
use App\Models\RemediationSetting;
use App\Models\User;
use App\Traits\HasGrade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Store extends Model implements HasMedia
{
    use HasGrade, HasSlug, InteractsWithMedia, LogsActivity;

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
        'phishing_is_enabled',
        'phishing_token',
        'phishing_ip',
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
        'fi_products_sold',
        'service_contracts',
        'tire_wheel',
        'other_fi',
        'fi_system',
        'appearance_protection_sold',
        'reinsurance',
        'admin_name',
        'user_submitted',
        'fi_username',
        'fi_password',
        'standard_dpp_rate',
        'courses_not_taken_notification',
        'remediations',
        'remediation_notifications',
        'frequency',
        'videos',
    ];
    protected $casts = [
        'ip_addresses' => 'array',
        'website_urls' => 'array',
        'monitoring_start_date' => 'date:Y-m-d',
        'currently_monitoring' => 'boolean',
        'service_contracts' => 'array',
        'tire_wheel' => 'array',
        'other_fi' => 'array',
        'reinsurance' => 'boolean',
        'user_submitted' => 'array',
        'courses_not_taken_notification' => 'boolean',
        'frequency' => Frequency::class,
        'remediation_notifications_last_sent' => 'datetime',
        'videos' => 'boolean',
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

    public function getDealJacketGradeAttribute(): ?string
    {
        return $this->calculateGrade($this->individualAudits->where('rating', '!=', null)->pluck('rating')->toArray());
    }

    public function getOverallGradeAttribute(): ?string
    {
        $this->load(['individualAudits', 'financeAudits', 'oshaAudits', 'bodyShopAudits']);

        $grades = array_merge(
            $this->individualAudits->where('rating', '!=', null)->pluck('rating')->toArray(),
            $this->financeAudits->where('rating', '!=', null)->pluck('rating')->toArray(),
            $this->oshaAudits->where('rating', '!=', null)->pluck('rating')->toArray(),
            $this->bodyShopAudits->where('rating', '!=', null)->pluck('rating')->toArray()
        );

        return $this->calculateGrade($grades);
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

    public function dealJacketGroups(): HasMany
    {
        return $this->hasMany(DealJacketGroup::class);
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

    public function oshaViolationAudits(): HasMany
    {
        return $this->hasMany(OshaViolationAudit::class);
    }

    public function BodyShopViolationAudits(): HasMany
    {
        return $this->hasMany(BodyShopViolationAudit::class);
    }

    public function GlbaViolationAudits(): HasMany
    {
        return $this->hasMany(GlbaViolationAudit::class);
    }

    public function redflags(): HasMany
    {
        return $this->hasMany(RedFlag::class);
    }

    public function cmsManuals(): HasMany
    {
        return $this->hasMany(CmsManual::class);
    }

    public function scanReports(): HasMany
    {
        return $this->hasMany(ScanReport::class);
    }

    public function latestScanReportDate(): HasOne
    {
        return $this->hasOne(ScanReport::class)->latest('last_scan');
    }

    public function docs(): HasMany
    {
        return $this->hasMany(DealerDoc::class);
    }

    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class);
    }

    public function phishingCampaigns(): HasMany
    {
        return $this->hasMany(PhishingCampaign::class);
    }

    public function ridgeback(): HasOne
    {
        return $this->hasOne(Ridgeback::class);
    }

    public function fitTests(): HasMany
    {
        return $this->hasMany(FitTestDoc::class);
    }

    public function remediationSettings(): HasOne
    {
        return $this->hasOne(RemediationSetting::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    private function calculateGrade(array $grades): ?string
    {
        if (count($grades) === 0) {
            return null;
        }

        $grade = round(array_sum($grades) / count($grades));

        if ($grade >= 90) {
            return 'A';
        }
        if ($grade >= 80) {
            return 'B';
        }
        if ($grade >= 70) {
            return 'C';
        }
        if ($grade >= 60) {
            return 'D';
        }

        return 'F';

    }
}
