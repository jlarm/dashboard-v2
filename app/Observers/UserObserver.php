<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class UserObserver
{
    public function saving(User $user): void
    {
        if ($user->isDirty('slug')) {
            return;
        }

        if ($user->exists && ! $user->isDirty('name')) {
            return;
        }

        if (empty($user->name)) {
            return;
        }

        $base = Str::slug($user->name);
        $slug = $base;
        $counter = 1;

        while (User::query()
            ->where('slug', $slug)
            ->when($user->exists, fn (Builder $query) => $query->where($user->getKeyName(), '!=', $user->getKey()))
            ->withTrashed()
            ->exists()
        ) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        $user->slug = $slug;
    }
}
