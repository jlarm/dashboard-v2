<?php

namespace App\Models\Dealer;

use App\Models\Dealer\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CourseResults extends Model
{
    protected $fillable = [
        'percentage',
        'passed',
        'course_id',
        'user_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
