<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Password;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Builder::macro('search', function ($field, $string) {
            return $string ? $this->where($field, 'like', "%$string%") : $this;
        });

        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });

        Password::defaults(fn () => Password::min(8)->uncompromised());
    }
}
