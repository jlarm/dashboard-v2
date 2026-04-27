<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Str;

function makeNotification(User $user, array $data = ['title' => 'Hello']): DatabaseNotification
{
    /** @var DatabaseNotification $notification */
    $notification = $user->notifications()->create([
        'id' => Str::uuid()->toString(),
        'type' => 'App\\Notifications\\TestNotification',
        'data' => $data,
    ]);

    return $notification;
}

describe('notifications endpoints', function (): void {
    it('marks a notification as read', function (): void {
        $notification = makeNotification($this->consultant);

        expect($notification->fresh()->read_at)->toBeNull();

        $this->actingAs($this->consultant)
            ->post(route('dealer.notifications.mark-read', $notification))
            ->assertRedirect();

        expect($notification->fresh()->read_at)->not->toBeNull();
    });

    it('marks every unread notification as read', function (): void {
        makeNotification($this->consultant);
        makeNotification($this->consultant);
        $alreadyRead = makeNotification($this->consultant);
        $alreadyRead->markAsRead();

        $this->actingAs($this->consultant)
            ->post(route('dealer.notifications.mark-all-read'))
            ->assertRedirect();

        expect($this->consultant->fresh()->unreadNotifications()->count())->toBe(0);
    });

    it('deletes a notification', function (): void {
        $notification = makeNotification($this->consultant);

        $this->actingAs($this->consultant)
            ->delete(route('dealer.notifications.destroy', $notification))
            ->assertRedirect();

        expect(DatabaseNotification::query()->find($notification->id))->toBeNull();
    });

    it('refuses to act on another user notification', function (): void {
        $notification = makeNotification($this->manager);

        $this->actingAs($this->consultant)
            ->post(route('dealer.notifications.mark-read', $notification))
            ->assertNotFound();

        $this->actingAs($this->consultant)
            ->delete(route('dealer.notifications.destroy', $notification))
            ->assertNotFound();

        expect($notification->fresh()->read_at)->toBeNull();
        expect(DatabaseNotification::query()->find($notification->id))->not->toBeNull();
    });
});
