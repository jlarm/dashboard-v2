<?php

declare(strict_types=1);

use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use App\Models\Department;
use Illuminate\Support\Facades\Bus;

beforeEach(function (): void {
    $this->department = Department::query()->create([
        'name' => 'Sales '.uniqid(),
        'slug' => 'sales-'.uniqid(),
    ]);

    $this->consultant->update(['department_id' => $this->department->id]);
});

describe('employees invite endpoint', function (): void {
    it('renders the invite page with option props', function (): void {
        $response = $this->actingAs($this->consultant)
            ->get(route('dealer.employees.invite'));

        $response->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/user/Invite')
                ->has('options.departments')
                ->has('options.roles')
                ->has('options.courses')
                ->has('options.stores'),
            );
    });

    it('creates an invite and dispatches an email job on success', function (): void {
        Bus::fake();

        $response = $this->actingAs($this->consultant)
            ->post(route('dealer.employees.invite.store'), [
                'name' => 'jane doe',
                'email' => 'JANE@example.com',
                'department_id' => $this->department->id,
                'role' => 'Employee',
                'qualified_individual' => false,
                'courses' => [],
            ]);

        $response->assertRedirect(route('dealer.employees.index'));
        $response->assertSessionHas('success');

        $invite = Invite::query()->firstOrFail();
        expect($invite->name)->toBe('Jane Doe');
        expect($invite->email)->toBe('jane@example.com');
        expect($invite->roles)->toContain('Employee');

        Bus::assertDispatchedTimes(SendQueueEmailJob::class, 1);
    });

    it('requires a primary store when multiple stores are assigned', function (): void {
        $secondStore = Store::query()->create([
            'name' => 'Second Store',
            'slug' => 'second-store-'.uniqid(),
        ]);

        $firstStore = Store::query()->firstOrFail();

        $response = $this->actingAs($this->consultant)
            ->post(route('dealer.employees.invite.store'), [
                'name' => 'No Primary',
                'email' => 'noprimary@example.com',
                'department_id' => $this->department->id,
                'role' => 'Employee',
                'store_ids' => [$firstStore->id, $secondStore->id],
            ]);

        $response->assertSessionHasErrors('primary_store_id');
        expect(Invite::query()->count())->toBe(0);
    });

    it('appends the Qualified Individual role when toggled on', function (): void {
        Bus::fake();

        $this->actingAs($this->consultant)
            ->post(route('dealer.employees.invite.store'), [
                'name' => 'QI Person',
                'email' => 'qi@example.com',
                'department_id' => $this->department->id,
                'role' => 'Employee',
                'qualified_individual' => true,
            ]);

        $invite = Invite::query()->firstOrFail();
        expect($invite->roles)->toContain('Employee')->toContain('Qualified Individual');
    });

    it('rejects duplicate emails', function (): void {
        Invite::query()->create([
            'name' => 'Existing',
            'email' => 'existing@example.com',
            'user_id' => $this->consultant->id,
            'department_id' => $this->department->id,
            'roles' => ['Employee'],
            'invitation_token' => 'token-'.uniqid(),
        ]);

        $response = $this->actingAs($this->consultant)
            ->post(route('dealer.employees.invite.store'), [
                'name' => 'Another',
                'email' => 'existing@example.com',
                'department_id' => $this->department->id,
                'role' => 'Employee',
            ]);

        $response->assertSessionHasErrors('email');
    });
});
