<?php

declare(strict_types=1);

use App\Domain\Central\User\Actions\CreateInviteAction;
use App\Domain\Central\User\Data\CreateInviteData;
use App\Models\Central\UserInvite;
use App\Models\User;
use App\Notifications\Central\UserInviteNotification;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
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

it('creates a consultant invite with a future expiry and records the inviter', function (): void {
    Notification::fake();

    $admin = User::factory()->create();
    $admin->assignRole('super-admin');

    $invite = resolve(CreateInviteAction::class)->execute(
        data: new CreateInviteData(name: 'Ada Lovelace', email: 'ada@example.com'),
        inviterId: $admin->id,
    );

    expect($invite)->toBeInstanceOf(UserInvite::class)
        ->and($invite->name)->toBe('Ada Lovelace')
        ->and($invite->email)->toBe('ada@example.com')
        ->and($invite->role)->toBe(UserInvite::CONSULTANT_ROLE)
        ->and($invite->invited_by)->toBe($admin->id)
        ->and($invite->expires_at->isFuture())->toBeTrue()
        ->and(now()->diffInDays($invite->expires_at))->toBeGreaterThanOrEqual(6);
});

it('sends an on-demand mail notification to the invitee', function (): void {
    Notification::fake();

    $admin = User::factory()->create();

    resolve(CreateInviteAction::class)->execute(
        data: new CreateInviteData(name: 'Linus', email: 'linus@example.com'),
        inviterId: $admin->id,
    );

    Notification::assertSentOnDemand(
        UserInviteNotification::class,
        fn ($notification, $channels, $notifiable) => in_array('mail', $channels, true)
            && $notifiable->routes['mail'] === 'linus@example.com',
    );
});
