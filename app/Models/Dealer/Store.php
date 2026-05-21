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
use App\Observers\Dealer\StoreObserver;
use App\Traits\HasGrade;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Override;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $state
 * @property bool $courses_not_taken_notification
 * @property int|null $scan_reports_count
 * @property-read RemediationSetting|null $remediationSettings
 */
#[ObservedBy(StoreObserver::class)]
class Store extends Model implements HasMedia
{
    use HasGrade, InteractsWithMedia, LogsActivity;

    #[Override]
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

    #[Override]
    protected $hidden = [
        'fi_password',
    ];

    /**
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return HasOne<DealerInfo, $this>
     */
    public function dealerInfo(): HasOne
    {
        return $this->hasOne(DealerInfo::class);
    }

    /**
     * @return HasOne<StoreSettings, $this>
     */
    public function storeSettings(): HasOne
    {
        return $this->hasOne(StoreSettings::class);
    }

    /**
     * @return HasOne<ScanSetting, $this>
     */
    public function scanSetting(): HasOne
    {
        return $this->hasOne(ScanSetting::class);
    }

    /**
     * @return HasMany<OshaAudit, $this>
     */
    public function oshaAudits(): HasMany
    {
        return $this->hasMany(OshaAudit::class);
    }

    /**
     * @return HasMany<BodyShopAudit, $this>
     */
    public function bodyShopAudits(): HasMany
    {
        return $this->hasMany(BodyShopAudit::class);
    }

    /**
     * @return HasMany<FinanceAudit, $this>
     */
    public function financeAudits(): HasMany
    {
        return $this->hasMany(FinanceAudit::class);
    }

    /**
     * @return HasMany<IndividualAudit, $this>
     */
    public function individualAudits(): HasMany
    {
        return $this->hasMany(IndividualAudit::class);
    }

    /**
     * @return HasMany<DealJacketGroup, $this>
     */
    public function dealJacketGroups(): HasMany
    {
        return $this->hasMany(DealJacketGroup::class);
    }

    /**
     * @return HasOne<EmployeeList, $this>
     */
    public function employeeList(): HasOne
    {
        return $this->hasOne(EmployeeList::class);
    }

    /**
     * @return HasMany<Isp, $this>
     */
    public function isps(): HasMany
    {
        return $this->hasMany(Isp::class);
    }

    /**
     * @return HasMany<Osha, $this>
     */
    public function oshas(): HasMany
    {
        return $this->hasMany(Osha::class);
    }

    /**
     * @return HasMany<OshaViolationAudit, $this>
     */
    public function oshaViolationAudits(): HasMany
    {
        return $this->hasMany(OshaViolationAudit::class);
    }

    /**
     * @return HasMany<BodyShopViolationAudit, $this>
     */
    public function bodyShopViolationAudits(): HasMany
    {
        return $this->hasMany(BodyShopViolationAudit::class);
    }

    /**
     * @return HasMany<GlbaViolationAudit, $this>
     */
    public function glbaViolationAudits(): HasMany
    {
        return $this->hasMany(GlbaViolationAudit::class);
    }

    /**
     * @return HasMany<RedFlag, $this>
     */
    public function redflags(): HasMany
    {
        return $this->hasMany(RedFlag::class);
    }

    /**
     * @return HasMany<CmsManual, $this>
     */
    public function cmsManuals(): HasMany
    {
        return $this->hasMany(CmsManual::class);
    }

    /**
     * @return HasMany<ScanReport, $this>
     */
    public function scanReports(): HasMany
    {
        return $this->hasMany(ScanReport::class);
    }

    /**
     * @return HasOne<ScanReport, $this>
     */
    public function latestScanReportDate(): HasOne
    {
        return $this->hasOne(ScanReport::class)->latest('last_scan');
    }

    /**
     * @return HasMany<DealerDoc, $this>
     */
    public function docs(): HasMany
    {
        return $this->hasMany(DealerDoc::class);
    }

    /**
     * @return HasMany<Vendor, $this>
     */
    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class);
    }

    /**
     * @return HasMany<PhishingCampaign, $this>
     */
    public function phishingCampaigns(): HasMany
    {
        return $this->hasMany(PhishingCampaign::class);
    }

    /**
     * @return HasOne<Ridgeback, $this>
     */
    public function ridgeback(): HasOne
    {
        return $this->hasOne(Ridgeback::class);
    }

    /**
     * @return HasMany<FitTestDoc, $this>
     */
    public function fitTests(): HasMany
    {
        return $this->hasMany(FitTestDoc::class);
    }

    /**
     * @return HasOne<RemediationSetting, $this>
     */
    public function remediationSettings(): HasOne
    {
        return $this->hasOne(RemediationSetting::class);
    }

    /**
     * @return HasOne<Cyrisma, $this>
     */
    public function cyrisma(): HasOne
    {
        return $this->hasOne(Cyrisma::class);
    }

    public function hasCyrismaShortName(): bool
    {
        return $this->cyrisma()->exists() && ! empty($this->cyrisma->short_name);
    }

    public function hasCyrismaInstanceId(): bool
    {
        return $this->cyrisma()->exists() && ! empty($this->cyrisma->instance_id);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logExcept(['phishing_token', 'phishing_ip', 'ip_addresses']);
    }

    protected function getPhoneNumberAttribute(): string
    {
        $cleaned = preg_replace('/[^[:digit:]]/', '', (string) $this->phone);
        preg_match('/(\d{3})(\d{3})(\d{4})/', (string) $cleaned, $matches);

        return "({$matches[1]}) {$matches[2]}-{$matches[3]}";
    }

    protected function getDealJacketGradeAttribute(): ?string
    {
        return $this->rememberGradeValue(
            'deal_jacket',
            function (): ?string {
                $latestRating = $this->individualAudits()
                    ->whereNotNull('rating')
                    ->latest('audit_date')
                    ->orderByDesc('id')
                    ->value('rating');

                if ($latestRating === null) {
                    return null;
                }

                return $this->calculateGrade([(float) $latestRating]);
            }
        );
    }

    protected function getOverallGradeAttribute(): ?string
    {
        return $this->rememberGradeValue(
            'overall',
            function (): ?string {
                $latestGrades = array_values(array_filter([
                    $this->deal_jacket_grade,
                    $this->osha_grade,
                    $this->glba_grade,
                    $this->body_shop_grade,
                ], fn (?string $grade): bool => in_array($grade, ['A', 'B', 'C', 'D', 'F'], true)));

                if ($latestGrades === []) {
                    return null;
                }

                $gradeValues = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'F' => 0];
                $total = array_reduce(
                    $latestGrades,
                    fn (int $carry, string $grade): int => $carry + $gradeValues[$grade],
                    0
                );
                $avg = $total / count($latestGrades);

                return match (true) {
                    $avg >= 3.5 => 'A',
                    $avg >= 2.5 => 'B',
                    $avg >= 1.5 => 'C',
                    $avg >= 0.5 => 'D',
                    default => 'F',
                };
            }
        );
    }

    #[Override]
    protected function casts(): array
    {
        return [
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
            'fi_password' => 'encrypted',
        ];
    }

    /**
     * @param  array<int, float|int>  $grades
     */
    private function calculateGrade(array $grades): ?string
    {
        if ($grades === []) {
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
