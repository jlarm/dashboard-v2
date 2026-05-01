<?php

declare(strict_types=1);

use App\Http\Middleware\CheckStoreStatusMiddleware;
use App\Http\Middleware\EnsureTenantIsNotSuspended;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\ImpersonationMiddleware;
use App\Http\Middleware\Localization;
use App\Http\Middleware\RequireTenantStoreMiddleware;
use App\Http\Middleware\SecurityHeadersMiddleware;
use App\Http\Middleware\SingleStoreMiddleware;
use App\Http\Middleware\StoreIdentifierMiddleware;
use App\Http\Middleware\StoreMiddleware;
use App\Providers\AppServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Sentry\Laravel\Integration;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
use Stancl\Tenancy\Contracts\TenantCouldNotBeIdentifiedException;
use Webklex\PDFMerger\Providers\PDFMergerServiceProvider;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        PDFMergerServiceProvider::class,
    ])
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn (): string => route('login'));
        $middleware->redirectUsersTo(AppServiceProvider::HOME);

        $middleware->append(SecurityHeadersMiddleware::class);

        $middleware->web([
            StoreIdentifierMiddleware::class,
            Localization::class,
            ImpersonationMiddleware::class,
            HandleInertiaRequests::class,
        ]);

        $middleware->alias([
            'has.stores' => CheckStoreStatusMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role' => RoleMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'single.store' => SingleStoreMiddleware::class,
            'stores' => StoreMiddleware::class,
            'tenant.not-suspended' => EnsureTenantIsNotSuspended::class,
            'tenant.requires-store' => RequireTenantStoreMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->reportable(function (Throwable $e): void {
            if (app()->bound('sentry')) {
                resolve('sentry')->captureException($e);
            }
        });

        $exceptions->renderable(function (UnauthorizedException $e, Request $request) {
            if (! auth()->check() && ! $request->expectsJson()) {
                $loginRoute = tenancy()->initialized ? 'dealer.login' : 'login';

                return redirect()->guest(route($loginRoute));
            }
        });

        $exceptions->renderable(function (TenantCouldNotBeIdentifiedException $e): never {
            abort(404);
        });

        Integration::handles($exceptions);
    })->create();
