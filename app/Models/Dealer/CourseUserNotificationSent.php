<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseUserNotificationSent extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'course_id',
        'sent',
    ];
    protected $casts = [
        'sent' => 'date',
    ];

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
