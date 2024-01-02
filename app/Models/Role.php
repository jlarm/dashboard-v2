<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $guarded = [];

    protected $guard_name = 'web';

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'model_has_roles', 'role_id', 'model_id');
    }
}
