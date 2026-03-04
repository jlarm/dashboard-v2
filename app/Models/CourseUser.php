<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseUser extends Pivot
{
    public $incrementing = false;
    protected $table = 'course_user';
    protected $fillable = ['user_id', 'course_id', 'type', 'assigned_by'];

    protected function setKeysForSaveQuery($query): Builder
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
