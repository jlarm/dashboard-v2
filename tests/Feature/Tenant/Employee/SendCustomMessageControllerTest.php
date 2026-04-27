<?php

declare(strict_types=1);

use App\Jobs\SendCustomEmployeeMessageJob;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();

    $this->consultant->stores()->attach($this->store->id);
    $this->consultant->update(['current_store_id' => $this->store->id]);
    $this->manager->stores()->attach($this->store->id);
    $this->manager->update(['current_store_id' => $this->store->id]);

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

function makeMessageRecipient(string $email = 'recipient@test.com'): User
{
    $user = User::query()->create([
        'name' => 'Recipient '.str()->random(4),
        'email' => $email,
        'password' => bcrypt('password'),
    ]);

    $user->assignRole('Employee');
    $user->stores()->attach(test()->store->id);

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    return $user;
}

describe('send-message endpoint', function (): void {
    it('queues a job for each selected user', function (): void {
        Bus::fake();

        $alice = makeMessageRecipient('alice@test.com');
        $bob = makeMessageRecipient('bob@test.com');

        $this
            ->actingAs($this->consultant)
            ->post(route('dealer.employees.send-message'), [
                'user_ids' => [$alice->id, $bob->id],
                'subject' => 'Hello team',
                'message_body' => 'Please complete your training.',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        Bus::assertDispatchedTimes(SendCustomEmployeeMessageJob::class, 2);
    });

    it('rejects employees and other low-privilege roles', function (): void {
        Bus::fake();

        $alice = makeMessageRecipient('alice@test.com');

        $this
            ->actingAs($this->manager)
            ->post(route('dealer.employees.send-message'), [
                'user_ids' => [$alice->id],
                'subject' => 'Hello',
                'message_body' => 'Body',
            ])
            ->assertForbidden();

        Bus::assertNothingDispatched();
    });

    it('validates required fields', function (): void {
        Bus::fake();

        $this
            ->actingAs($this->consultant)
            ->post(route('dealer.employees.send-message'), [
                'user_ids' => [],
            ])
            ->assertSessionHasErrors(['user_ids', 'subject', 'message_body']);

        Bus::assertNothingDispatched();
    });

    it('uses scoped query when select_all is set', function (): void {
        Bus::fake();

        makeMessageRecipient('alice@test.com');
        makeMessageRecipient('bob@test.com');

        $this
            ->actingAs($this->consultant)
            ->post(route('dealer.employees.send-message'), [
                'select_all' => '1',
                'subject' => 'Broadcast',
                'message_body' => 'To everyone',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        Bus::assertDispatched(SendCustomEmployeeMessageJob::class);
    });

    it('drops user_ids that the scope query excludes', function (): void {
        Bus::fake();

        // The scope query excludes users with super-admin or Consultant roles.
        // Submitting a Consultant id should silently drop that target.
        $excludedConsultant = User::query()->create([
            'name' => 'Excluded Consultant',
            'email' => 'excluded@test.com',
            'password' => bcrypt('password'),
        ]);
        $excludedConsultant->assignRole('Consultant');
        $excludedConsultant->stores()->attach($this->store->id);
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $allowed = makeMessageRecipient('allowed@test.com');

        $this
            ->actingAs($this->consultant)
            ->post(route('dealer.employees.send-message'), [
                'user_ids' => [$excludedConsultant->id, $allowed->id],
                'subject' => 'Mixed',
                'message_body' => 'Body',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        Bus::assertDispatchedTimes(SendCustomEmployeeMessageJob::class, 1);
    });
});
