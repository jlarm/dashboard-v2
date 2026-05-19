<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Department;
use Illuminate\Support\Str;

class DepartmentObserver
{
    public function saving(Department $department): void
    {
        if ($department->isDirty('slug')) {
            return;
        }

        if ($department->exists && ! $department->isDirty('name')) {
            return;
        }

        if (empty($department->name)) {
            return;
        }

        $base = Str::slug($department->name);
        $slug = $base;
        $counter = 1;

        while (Department::query()
            ->where('slug', $slug)
            ->when($department->exists, fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where($department->getKeyName(), '!=', $department->getKey()))
            ->exists()
        ) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        $department->slug = $slug;
    }
}
