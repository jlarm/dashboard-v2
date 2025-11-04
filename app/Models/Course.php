<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class Course extends Model
{
    use HasFactory, HasRoles;

    protected string $guard_name = 'web';
    protected $fillable = [
        'model_type',
        'department_id',
        'slug',
        'name',
        'slides',
        'questions',
        'video_id',
        'years_expires',
    ];
    protected $casts = [
        'slides' => 'array',
        'questions' => 'array',
        'answers' => 'array',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->morphToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(CourseResults::class);
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class);
    }
}
