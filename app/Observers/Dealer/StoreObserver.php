<?php

declare(strict_types=1);

namespace App\Observers\Dealer;

use App\Models\Dealer\Store;
use Illuminate\Support\Str;

class StoreObserver
{
    public function saving(Store $store): void
    {
        if ($store->isDirty('slug')) {
            return;
        }

        if ($store->exists && ! $store->isDirty('name')) {
            return;
        }

        if (empty($store->name)) {
            return;
        }

        $base = Str::slug($store->name);
        $slug = $base;
        $counter = 1;

        while (Store::query()
            ->where('slug', $slug)
            ->when($store->exists, fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where($store->getKeyName(), '!=', $store->getKey()))
            ->exists()
        ) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        $store->slug = $slug;
    }
}
