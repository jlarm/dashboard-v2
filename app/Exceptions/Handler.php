<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Stancl\Tenancy\Contracts\TenantCouldNotBeIdentifiedException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e): void {
            if (app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        });

        $this->renderable(function (UnauthorizedException $e, Request $request) {
            if (! auth()->check() && ! $request->expectsJson()) {
                $loginRoute = tenancy()->initialized ? 'dealer.login' : 'login';

                return redirect()->guest(route($loginRoute));
            }
        });

        $this->renderable(function (TenantCouldNotBeIdentifiedException $e): never {
            abort(404);
        });
    }
}
