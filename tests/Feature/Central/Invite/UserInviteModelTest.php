<?php

declare(strict_types=1);

use App\Models\Central\UserInvite;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('user_invites')->truncate();
    DB::table('model_has_roles')->truncate();
    DB::table('model_has_permissions')->truncate();
    DB::table('users')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

describe('isActive', function (): void {
    it('returns true when the invite has neither been accepted, revoked, nor expired', function (): void {
        $invite = UserInvite::factory()->create();

        expect($invite->isActive())->toBeTrue()
            ->and($invite->isInactive())->toBeFalse();
    });

    it('returns false once the invite has been accepted', function (): void {
        $invite = UserInvite::factory()->accepted()->create();

        expect($invite->isActive())->toBeFalse()
            ->and($invite->isInactive())->toBeTrue();
    });

    it('returns false once the invite has been revoked', function (): void {
        $invite = UserInvite::factory()->revoked()->create();

        expect($invite->isActive())->toBeFalse()
            ->and($invite->isInactive())->toBeTrue();
    });

    it('returns false once the invite has expired', function (): void {
        $invite = UserInvite::factory()->expired()->create();

        expect($invite->isActive())->toBeFalse()
            ->and($invite->isInactive())->toBeTrue();
    });
});

describe('open scope', function (): void {
    it('returns only invites that are unaccepted, unrevoked, and unexpired', function (): void {
        $open = UserInvite::factory()->create();
        $accepted = UserInvite::factory()->accepted()->create();
        $revoked = UserInvite::factory()->revoked()->create();
        $expired = UserInvite::factory()->expired()->create();

        $ids = UserInvite::query()
            ->open()
            ->whereIn('id', [$open->id, $accepted->id, $revoked->id, $expired->id])
            ->pluck('id')
            ->all();

        expect($ids)->toEqual([$open->id]);
    });
});
