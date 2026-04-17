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
        'states_required',
        'replaces_course_slugs',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(CourseResults::class);
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class);
    }

    protected function casts(): array
    {
        return [
            'slides' => 'array',
            'questions' => 'array',
            'answers' => 'array',
            'states_required' => 'array',
            'replaces_course_slugs' => 'array',
        ];
    }
}
