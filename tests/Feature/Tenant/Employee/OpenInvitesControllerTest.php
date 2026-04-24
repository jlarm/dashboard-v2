<?php

declare(strict_types=1);

use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Invite;
use App\Models\Department;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Str;

beforeEach(function (): void {
    $this->department = Department::query()->create([
        'name' => 'Open Invites Dept '.uniqid(),
        'slug' => 'open-invites-dept-'.uniqid(),
    ]);

    $this->invite = Invite::query()->create([
        'name' => 'Pending Hire',
        'email' => 'pending-hire@test.com',
        'stores' => [],
        'department_id' => $this->department->id,
        'user_id' => $this->consultant->id,
        'roles' => ['Employee'],
        'invitation_token' => Str::random(32),
        'courses' => [],
    ]);
});

describe('employees open-invites endpoint', function (): void {
    it('renders the open invites page for privileged users', function (): void {
        $response = $this->actingAs($this->consultant)
            ->get(route('dealer.employees.open-invites'));

        $response->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/user/OpenInvites')
                ->has('invites.data', 1)
                ->where('invites.data.0.email', 'pending-hire@test.com')
                ->has('departments')
                ->has('filters'),
            );
    });

    it('filters by search string', function (): void {
        Invite::query()->create([
            'name' => 'Someone Else',
            'email' => 'unrelated@test.com',
            'stores' => [],
            'department_id' => $this->department->id,
            'user_id' => $this->consultant->id,
            'roles' => ['Employee'],
            'invitation_token' => Str::random(32),
            'courses' => [],
        ]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.employees.open-invites', ['search' => 'Pending']))
            ->assertInertia(fn ($page) => $page
                ->has('invites.data', 1)
                ->where('invites.data.0.name', 'Pending Hire'),
            );
    });

    it('resends a single invite via the dedicated endpoint', function (): void {
        Bus::fake();

        $originalUpdatedAt = $this->invite->updated_at;

        $response = $this->actingAs($this->consultant)
            ->post(route('dealer.employees.open-invites.resend-one', $this->invite));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        Bus::assertDispatchedTimes(SendQueueEmailJob::class, 1);
        expect($this->invite->fresh()->updated_at->greaterThanOrEqualTo($originalUpdatedAt))->toBeTrue();
    });

    it('resends a batch of invites', function (): void {
        Bus::fake();

        $second = Invite::query()->create([
            'name' => 'Second Hire',
            'email' => 'second@test.com',
            'stores' => [],
            'department_id' => $this->department->id,
            'user_id' => $this->consultant->id,
            'roles' => ['Employee'],
            'invitation_token' => Str::random(32),
            'courses' => [],
        ]);

        $this->actingAs($this->consultant)
            ->post(route('dealer.employees.open-invites.resend'), [
                'invite_ids' => [$this->invite->id, $second->id],
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        Bus::assertDispatchedTimes(SendQueueEmailJob::class, 2);
    });

    it('deletes an open invite', function (): void {
        $this->actingAs($this->consultant)
            ->delete(route('dealer.employees.open-invites.destroy', $this->invite))
            ->assertRedirect()
            ->assertSessionHas('success');

        expect(Invite::query()->find($this->invite->id))->toBeNull();
    });

    it('forbids users without the create-dealerships permission', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.employees.open-invites'))
            ->assertForbidden();

        $this->actingAs($this->manager)
            ->delete(route('dealer.employees.open-invites.destroy', $this->invite))
            ->assertForbidden();

        expect(Invite::query()->find($this->invite->id))->not->toBeNull();
    });
});
