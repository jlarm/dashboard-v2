<?php

declare(strict_types=1);

use App\Http\Middleware\EnsureTenantIsNotSuspended;
use Illuminate\Http\Request;

it('passes the request through when the current tenant is not suspended', function (): void {
    expect($this->tenant->isSuspended())->toBeFalse();

    $response = new EnsureTenantIsNotSuspended()->handle(Request::create('/dashboard'), fn () => response('OK', 200));

    expect($response->getStatusCode())->toBe(200);
    expect((string) $response->getContent())->toBe('OK');
});

it('returns the tenant-suspended error view with status 503 when the tenant is suspended', function (): void {
    $this->withoutVite();

    $this->tenant->update(['suspended_at' => now()]);
    tenancy()->initialize($this->tenant->fresh());

    expect(tenant()->isSuspended())->toBeTrue();

    $nextCalled = false;
    $response = new EnsureTenantIsNotSuspended()->handle(Request::create('/dashboard'), function () use (&$nextCalled) {
        $nextCalled = true;

        return response('OK', 200);
    });

    expect($nextCalled)->toBeFalse();
    expect($response->getStatusCode())->toBe(503);
});
