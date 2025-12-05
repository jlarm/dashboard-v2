<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseUser extends Pivot
{
    public $incrementing = true;
    protected $table = 'course_user';
    protected $fillable = ['user_id', 'course_id', 'type', 'assigned_by'];
}
