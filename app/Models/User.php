<?php

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
use Stancl\Tenancy\Tenancy;

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
        'current_store_id',
        'last_sent_course_reminder',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_sent_course_reminder' => 'datetime',
    ];

    public function scopeWithoutSuperAdminsAndConsultants($query)
    {
        return $query->whereDoesntHave('roles', function ($q) {
            $q->whereIn('name', ['super-admin', 'Consultant']);
        });
    }

    public function currentStore(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'current_store_id');
    }

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

    public function dealerships(): BelongsToMany
    {
        return $this->belongsToMany(Dealership::class, 'tenant_user', 'user_id', 'tenant_id');
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

    public function fitTests(): HasMany
    {
        return $this->hasMany(FitTestDoc::class);
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

    public function getInitialsAttribute(): string
    {
        $name = explode(' ', $this->name);
        $initials = '';

        foreach ($name as $n) {
            $initials .= strtoupper($n[0]);
        }

        return $initials;
    }
}
