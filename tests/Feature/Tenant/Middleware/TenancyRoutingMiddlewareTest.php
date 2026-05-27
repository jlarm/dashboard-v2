<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

describe('InitializeTenancyByDomain', function (): void {
    it('initializes tenancy and resolves the matching tenant when the request domain is a tenant domain', function (): void {
        tenancy()->end();
        $request = Request::create('http://test-tenant.localhost/dashboard');

        app(InitializeTenancyByDomain::class)->handle($request, function () {
            expect(tenancy()->initialized)->toBeTrue();
            expect(tenant('id'))->toBe('test-tenant');

            return response('OK');
        });
    });

    it('refuses to initialize tenancy for an unknown domain', function (): void {
        tenancy()->end();
        $request = Request::create('http://nope.localhost/dashboard');

        $threw = false;
        try {
            app(InitializeTenancyByDomain::class)->handle($request, fn () => response('OK'));
        } catch (Throwable) {
            $threw = true;
        }

        expect($threw)->toBeTrue();
        expect(tenancy()->initialized)->toBeFalse();
    });
});

describe('PreventAccessFromCentralDomains', function (): void {
    it('aborts 404 when the request host matches a configured central_domain', function (): void {
        tenancy()->end();
        config(['tenancy.central_domains' => ['localhost']]);

        $request = Request::create('http://localhost/dashboard');

        expect(fn () => (new PreventAccessFromCentralDomains)
            ->handle($request, fn () => response('OK')))
            ->toThrow(Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);
    });

    it('lets the request through when the host is not in the central_domains list', function (): void {
        tenancy()->end();
        config(['tenancy.central_domains' => ['app.example.test']]);

        $request = Request::create('http://test-tenant.localhost/dashboard');

        $response = (new PreventAccessFromCentralDomains)->handle($request, fn () => response('OK', 200));

        expect($response->getStatusCode())->toBe(200);
    });
});
