<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Dealer\Course;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Override;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    #[Override]
    protected $guarded = [];

    protected string $guard_name = 'web';

    /**
     * @return BelongsToMany<Course, $this>
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }
}
