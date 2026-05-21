<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Abstracts\AbstractCourse;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Override;
use Spatie\Permission\Models\Role;

/**
 * @property array<int, string>|null $states_required
 * @property array<int, string>|null $replaces_course_slugs
 * @property array<int, mixed>|null $answers
 */
class Course extends AbstractCourse
{
    protected string $guard_name = 'web';

    #[Override]
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

    /**
     * @return BelongsToMany<Role, $this>
     */
    #[Override]
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'course_role');
    }

    /**
     * @return BelongsToMany<Dealership, $this>
     */
    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(Dealership::class, 'course_tenant', 'course_id', 'tenant_id')
            ->withTimestamps();
    }

    #[Override]
    protected function casts(): array
    {
        return [
            ...parent::casts(),
            'answers' => 'array',
            'states_required' => 'array',
            'replaces_course_slugs' => 'array',
        ];
    }
}
