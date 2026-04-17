<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Dealer\Store;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Override;

class StoreServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->app->singleton('currentStore', fn (): ?int => null);
        $this->app->singleton('multipleStoresExist', fn (): bool => Store::query()->count() > 1);
        $this->app->singleton('accessibleStoreIds', fn (): Collection => collect());
        $this->app->singleton('scopedStoreIds', fn (): Collection => collect());
    }

    public function boot(): void
    {
        App::macro('currentStore', fn () => resolve('currentStore'));
    }
}
