<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Dealer\Store;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class StoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('currentStore', fn (): ?int => null);
        $this->app->singleton('multipleStoresExist', fn (): bool => Store::query()->count() > 1);
        $this->app->singleton('accessibleStoreIds', fn () => collect());
        $this->app->singleton('scopedStoreIds', fn () => collect());
    }

    public function boot(): void
    {
        App::macro('currentStore', fn () => app('currentStore'));
    }
}
