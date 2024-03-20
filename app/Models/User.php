<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Department;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Store;
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
    use HasApiTokens, HasFactory, HasRoles, HasSlug, LogsActivity, Notifiable, SoftDeletes;

    protected $appends = ['user_has_not_completed_courses'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'store_id',
        'department_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
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

    private function totalUserCourses(): array
    {
        if (is_null($this->userCoursesCache)) {  // Check if already computed and cached
            // Eager load the roles relationship
            $this->load('roles');

            // Fetch the role IDs excluding the ID 5
            $userRoles = $this->roles->pluck('id')->reject(fn ($id) => $id == 5);

            // If there are no valid roles, return an empty array
            if ($userRoles->isEmpty()) {
                return [];
            }

            if (request()->getHost() === config('tenancy.central_domains')[0]) {
                $courseWithRole = DB::table('course_role')
                    ->whereIn('role_id', $userRoles)
                    ->pluck('model_id')
                    ->toArray();

                $this->userCoursesCache = Course::with('departments')
                    ->where(function ($query) use ($courseWithRole) {
                        $query->whereHas('departments', fn ($q) => $q->where('id', $this->department_id))
                            ->whereIn('id', $courseWithRole);
                    })
                    ->orWhereDoesntHave('departments')
                    ->pluck('id')
                    ->toArray();
            } else {
                $courseWithRole = DB::table('course_role')
                    ->whereIn('role_id', $userRoles)
                    ->pluck('course_id')
                    ->toArray();

                $this->userCoursesCache = Course::with('departments')
                    ->where(function ($query) use ($courseWithRole) {
                        $query->whereHas('departments', fn ($q) => $q->where('id', $this->department_id))
                            ->whereIn('id', $courseWithRole);
                    })
                    ->orWhereDoesntHave('departments')
                    ->when($this->userHasNoCaliforniaStore(), fn ($query) => $query->where('slug', '!=', 'sexual-harassment-training-in-california'))
                    ->pluck('id')
                    ->toArray();
            }
        }

        return $this->userCoursesCache;
    }

    public function getTotalCompletedCoursesAttribute(): int
    {
        return DB::table('course_results')
            ->distinct()
            ->select('course_id')
            ->where('user_id', $this->id)
            ->whereIn('course_id', $this->totalUserCourses())
            ->where(function ($query) {
                $query->where('created_at', '>=', now()->subYear())
                    ->orWhere(function ($query) {
                        $query->whereIn('course_id', [9, 10, 11, 12])
                            ->where('created_at', '>=', now()->subYears(3));
                    });
            })
            ->where('passed', 1)
            ->count('course_id');
    }

    public function getTotalUserCoursesAttribute(): int
    {
        return count($this->totalUserCourses());
    }

    public function getUserHasNotCompletedCoursesAttribute(): bool
    {
        return $this->total_completed_courses != $this->total_user_courses;
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

    public function invites()
    {
        return $this->hasMany(Invite::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function results()
    {
        return $this->hasMany(CourseResults::class);
    }

    public function redflags(): HasMany
    {
        return $this->hasMany(RedFlag::class);
    }

    public function individualAudits(): HasMany
    {
        return $this->hasMany(IndividualAudit::class, 'manager_id', 'id');
    }

    public function isps(): HasMany
    {
        return $this->hasMany(Isp::class);
    }

    public function oshas(): HasMany
    {
        return $this->hasMany(Osha::class);
    }

    public function oshaAudits(): HasMany
    {
        return $this->hasMany(OshaAudit::class);
    }

    public function bodyShopAudits(): HasMany
    {
        return $this->hasMany(BodyShopAudit::class);
    }

    public function glbaAudits(): HasMany
    {
        return $this->hasMany(FinanceAudit::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
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
