<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Department;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\PhishingCampaign;
use App\Models\Dealer\Store;
use App\Models\Dealer\Timeline;
use App\Traits\HasAudits;
use App\Traits\HasCourses;
use App\Traits\HasManuals;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        HasRoles,
        HasSlug,
        HasAudits,
        HasCourses,
        HasManuals,
        LogsActivity,
        Notifiable,
        SoftDeletes;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    protected $fillable = [
        'name',
        'email',
        'phone',
        'store_id',
        'department_id',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getPhoneNumberAttribute(): string
    {
        $cleaned = preg_replace('/[^[:digit:]]/', '', $this->phone);
        preg_match('/(\d{3})(\d{3})(\d{4})/', $cleaned, $matches);

        return "{$matches[1]}-{$matches[2]}-{$matches[3]}";
    }

    private function userHasNoCaliforniaStore(): bool
    {
        return ! $this->stores()->where('state', 'California')->exists();
    }

    public function dealerships(): HasMany
    {
        return $this->hasMany(Dealership::class);
    }

    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function invites(): HasMany
    {
        return $this->hasMany(Invite::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function phishingCampaigns(): HasMany
    {
        return $this->hasMany(PhishingCampaign::class);
    }

    public function timelines(): HasMany
    {
        return $this->hasMany(Timeline::class, 'email', 'email');
    }

    public function routeNotificationForVonage($notification)
    {
        return $this->phone;
    }

    public function scopeUserStore($query, $store): void
    {
        if ($store) {
            $query->whereHas('stores', function ($q) use ($store) {
                $q->where('store_id', $store->id);
            });
        }
    }

    public function scopeCurrentUserIsManager($query, $currentUser): void
    {
        if ($currentUser->hasRole('Manager') && ! $currentUser->hasRole('Qualified Individual')) {
            $query->where('department_id', $currentUser->department_id);
        }
    }

    public function scopeUsersNotCompletedCourses($query, $showNotCompleted): void
    {
        $query->when($showNotCompleted, fn ($query) => $query->where($this->user_has_not_completed_courses, true));
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }
}
