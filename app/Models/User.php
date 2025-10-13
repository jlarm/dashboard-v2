<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Dealer\Department;
use App\Models\Dealer\Invite;
use App\Models\Dealer\PhishingCampaign;
use App\Models\Dealer\Store;
use App\Models\Dealer\Timeline;
use App\Traits\HasAudits;
use App\Traits\HasCourses;
use App\Traits\HasManuals;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class User extends Authenticatable
{
    use HasApiTokens,
        HasAudits,
        HasCourses,
        HasFactory,
        HasManuals,
        HasRoles,
        HasSlug,
        LogsActivity,
        Notifiable,
        SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'store_id',
        'department_id',
        'password',
        'current_store_id',
        'last_sent_course_reminder',
        'email_verified_at',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_sent_course_reminder' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    public function scopeWithoutSuperAdminsAndConsultants(Builder $query): Builder
    {
        return $query->whereDoesntHave('roles', function ($q): void {
            $q->whereIn('name', ['super-admin', 'Consultant']);
        });
    }

    /**
     * @return BelongsTo<Store, User>
     */
    public function currentStore(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'current_store_id');
    }

    public function getPhoneNumberAttribute(): string
    {
        if (! $this->phone) {
            return '';
        }

        $cleaned = preg_replace('/[^[:digit:]]/', '', $this->phone);

        if (! is_string($cleaned) || ! preg_match('/(\d{3})(\d{3})(\d{4})/', $cleaned, $matches)) {
            return '';
        }

        return "{$matches[1]}-{$matches[2]}-{$matches[3]}";
    }

    /**
     * @return HasMany<Contract>
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * @return BelongsToMany<Dealership>
     */
    public function dealerships(): BelongsToMany
    {
        return $this->belongsToMany(Dealership::class, 'tenant_user', 'user_id', 'tenant_id');
    }

    /**
     * @return BelongsToMany<Store>
     */
    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class);
    }

    /**
     * @return BelongsTo<Department, User>
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @return HasMany<Invite>
     */
    public function invites(): HasMany
    {
        return $this->hasMany(Invite::class);
    }

    /**
     * @return HasMany<Certificate>
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * @return HasMany<PhishingCampaign>
     */
    public function phishingCampaigns(): HasMany
    {
        return $this->hasMany(PhishingCampaign::class);
    }

    /**
     * @return HasMany<Timeline>
     */
    public function timelines(): HasMany
    {
        return $this->hasMany(Timeline::class, 'email', 'email');
    }

    /**
     * @return HasMany<FitTestDoc>
     */
    public function fitTests(): HasMany
    {
        return $this->hasMany(FitTestDoc::class);
    }

    /**
     * @return HasMany<VideoProgress>
     */
    public function videoProgress(): HasMany
    {
        return $this->hasMany(VideoProgress::class);
    }

    /**
     * @return HasMany<RemediationReminderPreference>
     */
    public function remediationReminderPreferences(): HasMany
    {
        return $this->hasMany(RemediationReminderPreference::class);
    }

    /**
     * @param  Builder<User>  $query
     */
    public function scopeUserStore(Builder $query, ?Store $store): void
    {
        if ($store) {
            $query->whereHas('stores', function ($q) use ($store): void {
                $q->where('store_id', $store->id);
            });
        }
    }

    /**
     * @param  Builder<User>  $query
     */
    public function scopeCurrentUserIsManager(Builder $query, self $currentUser): void
    {
        if ($currentUser->hasRole('Manager') && ! $currentUser->hasRole('Qualified Individual')) {
            $query->where('department_id', $currentUser->department_id);
        }
    }

    /**
     * @param  Builder<User>  $query
     */
    public function scopeUsersNotCompletedCourses(Builder $query, bool $showNotCompleted): void
    {
        $query->when($showNotCompleted, fn ($query) => $query->where('user_has_not_completed_courses', true));
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function getInitialsAttribute(): string
    {
        $name = explode(' ', $this->name);
        $initials = '';

        foreach ($name as $n) {
            $initials .= mb_strtoupper($n[0]);
        }

        return $initials;
    }

    /**
     * Used in HasCourses trait
     *
     * @phpstan-ignore method.unused
     */
    private function userHasNoCaliforniaStore(): bool
    {
        // Use loaded stores collection if available, otherwise query
        if ($this->relationLoaded('stores')) {
            return ! $this->stores->contains('state', 'California');
        }

        return ! $this->stores()->where('state', 'California')->exists();
    }
}
