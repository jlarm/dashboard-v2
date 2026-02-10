<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! $this->app->isProduction());

        Request::macro('store', fn () => $this->user()?->currentStore());

        view()->composer('components.language-switcher', function ($view): void {
            $view->with('current_locale', app()->getLocale());
            $view->with('available_locales', config('app.available_locales'));
        });

        view()->composer('layouts.top-bar', function ($view): void {
            $view->with('current_locale', app()->getLocale());
            $view->with('available_locales', config('app.available_locales'));
        });

        Builder::macro('search', fn ($field, $string) => $string ? $this->where($field, 'like', '%'.$string.'%') : $this);

        Collection::macro('incomplete_courses', fn () => $this->map(fn (User $user) => $user->user_has_not_completed_courses));

        Builder::macro('toCsv', function () {
            $results = $this->get();

            if ($results->count() < 1) {
                return;
            }

            $titles = implode(',', array_keys($results->first()->getAttributes()));

            $values = $results->map(fn ($result): string => implode(',', collect($result->getAttributes())->map(fn ($value): string => '"'.$value.'"')->toArray()));

            $values->prepend($titles);

            return $values->implode("\n");
        });

        Collection::macro('toCSV', function (): string|false {
            $output = fopen('php://temp', 'r+');

            // Write the header
            if ($this->count() > 0) {
                fputcsv($output, array_keys($this->first()));
            }

            // Write the data
            foreach ($this as $row) {
                if (is_array($row) && array_filter($row, 'is_array') !== []) {
                    // Log the problematic row for inspection
                    Log::error('Problematic row:', $row);
                }

                fputcsv($output, $row->toArray());
            }

            rewind($output);

            return stream_get_contents($output);
        });

    }
}
