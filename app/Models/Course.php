<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Abstracts\AbstractCourse;
use Override;

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
