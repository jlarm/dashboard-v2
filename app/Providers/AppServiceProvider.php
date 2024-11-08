<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
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
        //        Model::preventLazyLoading(! $this->app->isProduction());

        view()->composer('components.language-switcher', function ($view) {
            $view->with('current_locale', app()->getLocale());
            $view->with('available_locales', config('app.available_locales'));
        });

        view()->composer('layouts.top-bar', function ($view) {
            $view->with('current_locale', app()->getLocale());
            $view->with('available_locales', config('app.available_locales'));
        });

        Builder::macro('search', function ($field, $string) {
            return $string ? $this->where($field, 'like', '%'.$string.'%') : $this;
        });

        Collection::macro('incomplete_courses', function () {
            return $this->map(fn ($user) => $user->incomplete_courses());
        });

        Builder::macro('toCsv', function () {
            $results = $this->get();

            if ($results->count() < 1) {
                return;
            }

            $titles = implode(',', array_keys($results->first()->getAttributes()));

            $values = $results->map(function ($result) {
                return implode(',', collect($result->getAttributes())->map(function ($value) {
                    return '"'.$value.'"';
                })->toArray());
            });

            $values->prepend($titles);

            return $values->implode("\n");
        });

        Collection::macro('toCSV', function () {
            $output = fopen('php://temp', 'r+');

            // Write the header
            if ($this->count() > 0) {
                fputcsv($output, array_keys($this->first()));
            }

            // Write the data
            foreach ($this as $row) {
                if (is_array($row) && count(array_filter($row, 'is_array')) > 0) {
                    // Log the problematic row for inspection
                    \Log::error('Problematic row:', $row);
                }

                fputcsv($output, $row->toArray());
            }

            rewind($output);

            return stream_get_contents($output);
        });

    }
}
