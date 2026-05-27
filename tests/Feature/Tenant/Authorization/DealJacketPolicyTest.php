<?php

declare(strict_types=1);

use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\User;
use App\Policies\DealJacketGroupPolicy;
use App\Policies\DealJacketPolicy;

function makeDealJacketUser(string $role): User
{
    $user = User::query()->create([
        'name' => $role.' Tester',
        'email' => mb_strtolower(str_replace(' ', '-', $role)).'-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('x'),
    ]);
    $user->assignRole($role);

    return $user;
}

describe('DealJacketPolicy', function (): void {
    $policy = new DealJacketPolicy;
    $jacket = new DealJacket;

    foreach (['create', 'update', 'delete'] as $method) {
        it("allows super-admin to {$method}", function () use ($policy, $jacket, $method): void {
            $user = makeDealJacketUser('super-admin');
            expect($policy->{$method}($user, $jacket))->toBeTrue();
        });

        it("allows Consultant to {$method}", function () use ($policy, $jacket, $method): void {
            $user = makeDealJacketUser('Consultant');
            expect($policy->{$method}($user, $jacket))->toBeTrue();
        });

        it("denies Manager to {$method}", function () use ($policy, $jacket, $method): void {
            $user = makeDealJacketUser('Manager');
            expect($policy->{$method}($user, $jacket))->toBeFalse();
        });

        it("denies Employee to {$method}", function () use ($policy, $jacket, $method): void {
            $user = makeDealJacketUser('Employee');
            expect($policy->{$method}($user, $jacket))->toBeFalse();
        });
    }
});

describe('DealJacketGroupPolicy', function (): void {
    $policy = new DealJacketGroupPolicy;
    $group = new DealJacketGroup;

    foreach (['create', 'update', 'delete'] as $method) {
        it("allows super-admin to {$method}", function () use ($policy, $group, $method): void {
            $user = makeDealJacketUser('super-admin');
            expect($policy->{$method}($user, $group))->toBeTrue();
        });

        it("allows Consultant to {$method}", function () use ($policy, $group, $method): void {
            $user = makeDealJacketUser('Consultant');
            expect($policy->{$method}($user, $group))->toBeTrue();
        });

        it("denies Manager to {$method}", function () use ($policy, $group, $method): void {
            $user = makeDealJacketUser('Manager');
            expect($policy->{$method}($user, $group))->toBeFalse();
        });

        it("denies Employee to {$method}", function () use ($policy, $group, $method): void {
            $user = makeDealJacketUser('Employee');
            expect($policy->{$method}($user, $group))->toBeFalse();
        });
    }
});
