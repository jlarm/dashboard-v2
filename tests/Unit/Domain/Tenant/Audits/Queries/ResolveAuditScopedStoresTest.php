<?php

declare(strict_types=1);

use App\Domain\Tenant\Audits\Queries\ResolveAuditScopedStores;
use Illuminate\Support\Collection;

afterEach(function (): void {
    if (app()->bound('scopedStoreIds')) {
        app()->offsetUnset('scopedStoreIds');
    }
});

it('returns an empty collection when scopedStoreIds is not bound', function (): void {
    expect((new ResolveAuditScopedStores())->handle())
        ->toBeInstanceOf(Collection::class)
        ->toBeEmpty();
});

it('returns the bound store ids cast to ints', function (): void {
    app()->instance('scopedStoreIds', collect(['7', 12, '3']));

    $resolved = (new ResolveAuditScopedStores())->handle();

    expect($resolved->all())->toBe([7, 12, 3]);
});

it('preserves an empty bound collection', function (): void {
    app()->instance('scopedStoreIds', collect());

    expect((new ResolveAuditScopedStores())->handle())->toBeEmpty();
});
