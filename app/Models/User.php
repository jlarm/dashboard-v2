<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Role;
use App\Models\Dealer\Department;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use App\Notifications\ResetPassword;
use App\Observers\UserObserver;
use App\Traits\HasCourses;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Override;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $slug
 * @property Carbon|null $last_sent_course_reminder
 * @property Carbon|null $last_login_at
 * @property-read int $total_user_courses
 * @property-read int $total_completed_courses
 * @property-read int|null $completed_courses_count
 * @property-read bool $user_has_not_completed_courses
 */
#[ObservedBy(UserObserver::class)]
class User extends Authenticatable implements MustVerifyEmail
{
    /**
     * @use HasFactory<UserFactory>
     */
    use HasApiTokens,
        HasCourses,
        HasFactory,
        HasRoles,
        LogsActivity,
        Notifiable,
        SoftDeletes;

    #[Override]
    protected $fillable = [
        'name',
        'email',
        'phone',
        'store_id',
        'department_id',
        'password',
        'current_store_id',
        'primary_store_id',
        'last_sent_course_reminder',
        'email_verified_at',
    ];

    #[Override]
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return BelongsTo<Store, $this>
     */
    public function currentStore(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'current_store_id');
    }

    /**
     * @return BelongsTo<Store, $this>
     */
    public function primaryStore(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'primary_store_id');
    }

    public function currentStoreName(): string
    {
        return $this->currentStore()->name ?? tenant('name');
    }

    /**
     * @return HasMany<Contract, $this>
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * @return BelongsToMany<Dealership, $this>
     */
    public function dealerships(): BelongsToMany
    {
        return $this->belongsToMany(Dealership::class, 'tenant_user', 'user_id', 'tenant_id');
    }

    /**
     * @return BelongsToMany<Store, $this>
     */
    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class);
    }

    /**
     * @return BelongsTo<Department, $this>
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @return HasMany<Invite, $this>
     */
    public function invites(): HasMany
    {
        return $this->hasMany(Invite::class);
    }

    /**
     * @return HasMany<Certificate, $this>
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * @return HasMany<FitTestDoc, $this>
     */
    public function fitTests(): HasMany
    {
        return $this->hasMany(FitTestDoc::class);
    }

    /**
     * @return HasMany<VideoProgress, $this>
     */
    public function videoProgress(): HasMany
    {
        return $this->hasMany(VideoProgress::class);
    }

    /**
     * @return HasMany<RemediationReminderPreference, $this>
     */
    public function remediationReminderPreferences(): HasMany
    {
        return $this->hasMany(RemediationReminderPreference::class);
    }

    /**
     * @param  string  $token
     */
    #[Override]
    public function sendPasswordResetNotification($token): void // @pest-ignore-type
    {
        $this->notify(new ResetPassword($token));
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logExcept(['password', 'remember_token']);
    }

    /**
     * @return HasMany<CourseUser, $this>
     */
    public function courseOverrides(): HasMany
    {
        return $this->hasMany(CourseUser::class, 'user_id');
    }

    public function primaryRoleName(): ?string
    {
        return $this->roles->first()->name ?? '';
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    protected function scopeWithoutSuperAdminsAndConsultants(Builder $query): Builder
    {
        return $query->whereDoesntHave('roles', function (Builder $q): void {
            $q->whereIn('name', [Role::SuperAdmin->value, Role::Consultant->value]);
        });
    }

    protected function getPhoneNumberAttribute(): string
    {
        if (! $this->phone) {
            return '';
        }

        $cleaned = preg_replace('/[^[:digit:]]/', '', (string) $this->phone);

        if (! is_string($cleaned) || ! preg_match('/(\d{3})(\d{3})(\d{4})/', $cleaned, $matches)) {
            return '';
        }

        return "{$matches[1]}-{$matches[2]}-{$matches[3]}";
    }

    /**
     * @param  Builder<User>  $query
     */
    protected function scopeUserStore(Builder $query, ?Store $store): void
    {
        if ($store instanceof Store) {
            $query->whereHas('stores', function (Builder $q) use ($store): void {
                $q->where('store_id', $store->id);
            });
        }
    }

    /**
     * @param  Builder<User>  $query
     */
    protected function scopeCurrentUserIsManager(Builder $query, self $currentUser): void
    {
        if ($currentUser->hasRole(Role::Manager->value) && ! $currentUser->hasRole(Role::QualifiedIndividual->value)) {
            $query->where('department_id', $currentUser->department_id);
        }
    }

    /**
     * @param  Builder<User>  $query
     */
    protected function scopeUsersNotCompletedCourses(Builder $query, bool $showNotCompleted): void
    {
        $query->when($showNotCompleted, fn (Builder $query) => $query->where('user_has_not_completed_courses', true));
    }

    /**
     * @return Attribute<string, never>
     */
    protected function initials(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes): string {
                $name = $attributes['name'] ?? '';

                return Str::upper(
                    Str::of($name)
                        ->trim()
                        ->explode(' ')
                        ->filter()
                        ->take(2)
                        ->map(fn (string $word) => Str::substr($word, 0, 1))
                        ->implode('')
                );
            }
        );
    }

    /**
     * @return Attribute<string|null, string|null>
     */
    protected function email(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value): ?string => $value === null ? null : Str::lower($value),
            set: fn (?string $value): ?string => $value === null ? null : Str::lower(mb_trim($value)),
        );
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'department_id' => 'integer',
            'name' => 'string',
            'slug' => 'string',
            'email' => 'string',
            'phone' => 'string',
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'current_store_id' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'last_sent_course_reminder' => 'datetime',
        ];
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    protected function scopeWithCompletedCoursesCount(Builder $query): Builder
    {
        return $query
            ->select('users.*')
            ->selectSub(
                CourseResults::query()
                    ->selectRaw('COUNT(DISTINCT course_id)')
                    ->whereColumn('user_id', 'users.id')
                    ->where('passed', 1),
                'completed_courses_count'
            );
    }
}
