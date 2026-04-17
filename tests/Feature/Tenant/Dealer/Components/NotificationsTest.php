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

        $notification = DatabaseNotification::query()->create([
            'id' => fake()->uuid(),
            'type' => 'App\Notifications\TestNotification',
            'notifiable_type' => $this->consultant::class,
            'notifiable_id' => $this->consultant->id,
            'data' => ['message' => 'Test notification'],
        ]);

        Livewire::test(Notifications::class)
            ->call('markAsRead', $notification->toArray())
            ->assertDispatched('notification');

        $this->assertDatabaseMissing('notifications', ['id' => $notification->id]);
    });

    it('does not throw when marking a non-existent notification as read', function (): void {
        $this->actingAs($this->consultant);

        Livewire::test(Notifications::class)
            ->call('markAsRead', ['id' => fake()->uuid()])
            ->assertDispatched('notification');
    });

    it('can mark all notifications as read', function (): void {
        $this->actingAs($this->consultant);

        DatabaseNotification::query()->create([
            'id' => fake()->uuid(),
            'type' => 'App\Notifications\TestNotification',
            'notifiable_type' => $this->consultant::class,
            'notifiable_id' => $this->consultant->id,
            'data' => ['message' => 'Notification 1'],
        ]);

        DatabaseNotification::query()->create([
            'id' => fake()->uuid(),
            'type' => 'App\Notifications\TestNotification',
            'notifiable_type' => $this->consultant::class,
            'notifiable_id' => $this->consultant->id,
            'data' => ['message' => 'Notification 2'],
        ]);

        Livewire::test(Notifications::class)
            ->call('markAllAsRead')
            ->assertDispatched('notification');

        expect($this->consultant->fresh()->unreadNotifications)->toHaveCount(0);
    });
});
