<?php

namespace App\Models\Dealer;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseResults extends Model
{
    protected $fillable = [
        'percentage',
        'passed',
        'course_id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
