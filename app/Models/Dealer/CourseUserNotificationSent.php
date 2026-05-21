<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

class CourseUserNotificationSent extends Model
{
    #[Override]
    public $timestamps = false;

    #[Override]
    protected $fillable = [
        'user_id',
        'course_id',
        'sent',
    ];

    #[Override]
    protected function casts(): array
    {
        return [
            'sent' => 'date',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Course, $this>
     */
    protected function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
