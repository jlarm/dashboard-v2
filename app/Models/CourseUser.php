<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Override;

class CourseUser extends Pivot
{
    #[Override]
    public $incrementing = false;

    #[Override]
    protected $table = 'course_user';

    #[Override]
    protected $fillable = ['user_id', 'course_id', 'type', 'assigned_by'];

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    #[Override]
    protected function setKeysForSaveQuery($query): Builder // @pest-ignore-type
    {
        foreach (['user_id', 'course_id'] as $keyName) {
            $query->where($keyName, '=', $this->resolveCompositeKeyForSaveQuery($keyName));
        }

        return $query;
    }

    private function resolveCompositeKeyForSaveQuery(string $keyName): mixed
    {
        return $this->original[$keyName] ?? $this->getAttribute($keyName);
    }
}
