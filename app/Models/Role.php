<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Dealer\Course;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $guarded = [];
    protected $guard_name = 'web';

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }
}
