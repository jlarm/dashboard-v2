<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class StoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('currentStore', function () {
            return null;
        });
    }

    public function boot(): void
    {
    }
}
