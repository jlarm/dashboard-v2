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
        $this->app->singleton('currentStore', function ($app) {
            $request = $app['request'];

            if ($storeSlug = $request->segment(2)) {
                return Store::where('slug', $storeSlug)->first();
            }

            if ($store = $request->get('store')) {
                return $store;
            }

            if (! tenant('locations')) {
                return Store::first();
            }

            return null;
        });
    }

    public function boot(): void
    {
        App::macro('current_store', fn () => app('currentStore'));
    }
}
