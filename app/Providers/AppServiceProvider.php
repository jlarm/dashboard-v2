<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\Role;
use App\Models\Central\UserInvite;
use App\Models\Contract;
use App\Models\Course;
use App\Models\CourseResults;
use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Models\DealerDoc;
use App\Models\Dealership;
use App\Models\Document;
use App\Models\Sds;
use App\Models\SharedDocument;
use App\Models\User;
use App\Models\ViolationStatement;
use App\Observers\CourseResultsObserver;
use App\Policies\Central\ContractPolicy;
use App\Policies\Central\DealershipPolicy;
use App\Policies\Central\DocumentPolicy;
use App\Policies\Central\InvitePolicy;
use App\Policies\Central\SdsPolicy;
use App\Policies\Central\SharedDocumentPolicy;
use App\Policies\Central\UserPolicy;
use App\Policies\Central\ViolationStatementPolicy;
use App\Policies\CoursePolicy;
use App\Policies\DealerDocPolicy;
use App\Policies\GlobalSettingPolicy;
use App\Policies\StorePolicy;
use App\Policies\VendorPolicy;
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
use Illuminate\View\View;
use Override;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     */
    public const string HOME = '/dashboard';

    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        $this->app->singleton(UserCourseService::class);
        $this->app->singleton(StoreScopeService::class);

        $this->app->singleton('laravel-pdf.driver.cloudflare', fn (): \App\Pdf\CloudflareDriver => new \App\Pdf\CloudflareDriver(config('laravel-pdf.cloudflare', [])));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! $this->app->isProduction());

        Request::macro('store', fn () => $this->user()?->currentStore());

        view()->composer('components.language-switcher', function (View $view): void {
            $view->with('current_locale', app()->getLocale());
            $view->with('available_locales', config('app.available_locales'));
        });

        view()->composer('layouts.top-bar', function (View $view): void {
            $view->with('current_locale', app()->getLocale());
            $view->with('available_locales', config('app.available_locales'));
        });

        Builder::macro('search', fn (string $field, ?string $string) => $string ? $this->where($field, 'like', '%'.$string.'%') : $this);

        Collection::macro('incomplete_courses', fn () => $this->map(fn (mixed $user): bool => $user instanceof User && $user->user_has_not_completed_courses));

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

            $values = $results->map(function (mixed $result): string {
                $attributes = (array) $result;

                return implode(',', collect($attributes)->map(fn (mixed $value): string => '"'.$value.'"')->all());
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
        Gate::before(fn (User $user, string $ability): ?true => $user->hasRole(Role::SuperAdmin->value) ? true : null);

        Gate::policy(Contract::class, ContractPolicy::class);
        Gate::policy(Course::class, CoursePolicy::class);
        Gate::policy(Dealership::class, DealershipPolicy::class);
        Gate::policy(DealerDoc::class, DealerDocPolicy::class);
        Gate::policy(Document::class, DocumentPolicy::class);
        Gate::policy(GlobalSetting::class, GlobalSettingPolicy::class);
        Gate::policy(Sds::class, SdsPolicy::class);
        Gate::policy(SharedDocument::class, SharedDocumentPolicy::class);
        Gate::policy(Store::class, StorePolicy::class);
        Gate::policy(UserInvite::class, InvitePolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Vendor::class, VendorPolicy::class);
        Gate::policy(ViolationStatement::class, ViolationStatementPolicy::class);

        Password::defaults(fn () => Password::min(8)->uncompromised());
    }

    public function bootEvent(): void
    {
        CourseResults::observe(CourseResultsObserver::class);
    }
}
