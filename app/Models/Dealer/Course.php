<?php

namespace App\Models\Dealer;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'department_id',
        'slug',
        'name',
        'slides',
        'questions',
    ];

    protected $casts = [
        'slides' => 'array',
        'questions' => 'array',
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
}
