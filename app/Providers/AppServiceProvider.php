<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use App\Services\StoreScopeService;
use App\Services\UserCourseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Livewire\Blaze\Blaze;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserCourseService::class);
        $this->app->singleton(StoreScopeService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('blaze.debug', false) && class_exists(Blaze::class)) {
            Blaze::debug();
        }

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

        Collection::macro('incomplete_courses', fn () => $this->map(fn ($user): bool => $user instanceof User && $user->user_has_not_completed_courses));

        Builder::macro('toCsv', function () {
            $results = $this->get();

            if ($results->count() < 1) {
                return;
            }

            $firstResult = $results->first();

            if ($firstResult === null) {
                return;
            }

            $firstAttributes = (array) $firstResult;

            $titles = implode(',', array_keys($firstAttributes));

            $values = $results->map(function ($result): string {
                $attributes = (array) $result;

                return implode(',', collect($attributes)->map(fn ($value): string => '"'.$value.'"')->toArray());
            });

            $values->prepend($titles);

            return $values->implode("\n");
        });

        Collection::macro('toCSV', function (): string|false {
            $output = fopen('php://temp', 'r+');

            // Write the header
            if ($this->count() > 0) {
                $first = $this->first();

                if ($first === null) {
                    return false;
                }

                $firstRow = $first->toArray();

                fputcsv($output, array_keys($firstRow));
            }

            // Write the data
            foreach ($this as $row) {
                $rowData = $row->toArray();

                if (array_filter($rowData, 'is_array') !== []) {
                    // Log the problematic row for inspection
                    Log::error('Problematic row:', ['row' => $rowData]);
                }

                fputcsv($output, $rowData);
            }

            rewind($output);

            return stream_get_contents($output);
        });

    }
}
