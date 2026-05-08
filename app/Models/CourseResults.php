<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

/**
 * @property int $id
 * @property int $percentage
 * @property bool $passed
 * @property int $course_id
 * @property int $user_id
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class CourseResults extends Model
{
    #[Override]
    protected $fillable = [
        'percentage',
        'passed',
        'course_id',
        'user_id',
    ];

    /**
     * @return BelongsTo<Course, $this>
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'percentage' => 'integer',
            'passed' => 'boolean',
            'course_id' => 'integer',
            'user_id' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
