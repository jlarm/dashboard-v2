<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Dealer\Department;
use App\Models\Dealer\Invite;
use App\Models\Dealer\PhishingCampaign;
use App\Models\Dealer\Store;
use App\Models\Dealer\Timeline;
use App\Traits\EmployeeCourses;
use App\Traits\HasAudits;
use App\Traits\HasManuals;
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
        EmployeeCourses,
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

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(CourseResults::class);
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
