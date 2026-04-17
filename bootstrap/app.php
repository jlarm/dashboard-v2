<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders()
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        // api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        // channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->redirectUsersTo(RouteServiceProvider::HOME);

        $middleware->append(\App\Http\Middleware\SecurityHeadersMiddleware::class);

        $middleware->web([
            \App\Http\Middleware\StoreIdentifierMiddleware::class,
            \App\Http\Middleware\Localization::class,
            \App\Http\Middleware\ImpersonationMiddleware::class,
        ]);

        $middleware->group('universal', [
            ],
            'api' => [,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->alias([
            'has.stores' => \App\Http\Middleware\CheckStoreStatusMiddleware::class,
            'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
            'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
            'single.store' => \App\Http\Middleware\SingleStoreMiddleware::class,
            'stores' => \App\Http\Middleware\StoreMiddleware::class,
            'tenant.not-suspended' => \App\Http\Middleware\EnsureTenantIsNotSuspended::class,
            'tenant.requires-store' => \App\Http\Middleware\RequireTenantStoreMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
