<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Components\Notifications;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Livewire;

describe('Notifications Component', function (): void {
    it('renders successfully', function (): void {
        $this->actingAs($this->consultant);

        Livewire::test(Notifications::class)
            ->assertStatus(200);
    });

    it('can mark a notification as read', function (): void {
        $this->actingAs($this->consultant);

        $notification = DatabaseNotification::create([
            'id' => fake()->uuid(),
            'type' => 'App\Notifications\TestNotification',
            'notifiable_type' => get_class($this->consultant),
            'notifiable_id' => $this->consultant->id,
            'data' => ['message' => 'Test notification'],
        ]);

        Livewire::test(Notifications::class)
            ->call('markAsRead', $notification->toArray())
            ->assertEmitted('notification');

        $this->assertDatabaseMissing('notifications', ['id' => $notification->id]);
    });

    it('does not throw when marking a non-existent notification as read', function (): void {
        $this->actingAs($this->consultant);

        Livewire::test(Notifications::class)
            ->call('markAsRead', ['id' => fake()->uuid()])
            ->assertEmitted('notification');
    });

    it('can mark all notifications as read', function (): void {
        $this->actingAs($this->consultant);

        DatabaseNotification::create([
            'id' => fake()->uuid(),
            'type' => 'App\Notifications\TestNotification',
            'notifiable_type' => get_class($this->consultant),
            'notifiable_id' => $this->consultant->id,
            'data' => ['message' => 'Notification 1'],
        ]);

        DatabaseNotification::create([
            'id' => fake()->uuid(),
            'type' => 'App\Notifications\TestNotification',
            'notifiable_type' => get_class($this->consultant),
            'notifiable_id' => $this->consultant->id,
            'data' => ['message' => 'Notification 2'],
        ]);

        Livewire::test(Notifications::class)
            ->call('markAllAsRead')
            ->assertEmitted('notification');

        expect($this->consultant->fresh()->unreadNotifications)->toHaveCount(0);
    });
});
