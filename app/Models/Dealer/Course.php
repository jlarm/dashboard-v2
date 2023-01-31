<?php

namespace App\Models\Dealer;

use App\Models\Dealer\CourseResults;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Course extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'slides',
        'questions',
    ];

    protected $casts = [
        'slides' => 'array',
        'questions' => 'array',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function results()
    {
        return $this->hasMany(CourseResults::class);
    }

}
