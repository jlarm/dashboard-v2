<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\CourseResults;
use App\Models\User;
use App\Observers\CourseResultsObserver;
use App\Observers\UserObserver;
use App\Services\StoreScopeService;
use App\Services\UserCourseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Override;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Register any application services.
     */
    #[Override]
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

                return implode(',', collect($attributes)->map(fn ($value): string => '"'.$value.'"')->all());
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

                fputcsv($output, array_keys($firstRow), escape: '\\');
            }

            // Write the data
            foreach ($this as $row) {
                $rowData = $row->toArray();

                if (array_filter($rowData, is_array(...)) !== []) {
                    // Log the problematic row for inspection
                    Log::error('Problematic row:', ['row' => $rowData]);
                }

                fputcsv($output, $rowData, escape: '\\');
            }

            rewind($output);

            return stream_get_contents($output);
        });

        $this->bootAuth();
        $this->bootEvent();
    }

    public function bootAuth(): void
    {

        Gate::before(fn ($user, $ability): ?true => $user->hasRole('super-admin') ? true : null);

        Password::defaults(fn () => Password::min(8)->uncompromised());
    }

    public function bootEvent(): void
    {
        User::observe(UserObserver::class);
        CourseResults::observe(CourseResultsObserver::class);
    }
}
