<?php

declare(strict_types=1);

use App\Domain\Central\Dealership\Actions\CreateDealership;
use App\Domain\Central\Dealership\Data\DealershipData;
use App\Models\Dealership;
use App\Models\User;
use App\Notifications\NewDealershipNotification;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\PermissionRegistrar;

use function Pest\Laravel\mock;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('domains')->truncate();
    DB::table('tenant_user')->truncate();
    DB::table('tenants')->truncate();
    DB::table('model_has_roles')->truncate();
    DB::table('model_has_permissions')->truncate();
    DB::table('users')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

function existingDealershipNamed(string $name): Dealership
{
    $owner = User::factory()->create();

    $dealership = new Dealership([
        'name' => $name,
        'user_id' => $owner->id,
    ]);
    $dealership->setInternal('create_database', false);
    $dealership->save();
    $dealership->domains()->create(['domain' => str()->slug($name).'.localhost']);

    return $dealership;
}

describe('authorization', function (): void {
    it('redirects guests to login', function (): void {
        $this->post(route('dealerships.store'), ['name' => 'Guest Auto'])
            ->assertRedirect(route('login'));
    });

    it('forbids users with neither super-admin nor Consultant', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('dealerships.store'), ['name' => 'Random Motors'])
            ->assertForbidden();
    });

    it('allows super-admins to hit the store endpoint', function (): void {
        mock(CreateDealership::class)
            ->shouldReceive('handle')
            ->once()
            ->andReturn(new Dealership(['name' => 'Super Motors']));

        asSuperAdmin()
            ->from(route('dealerships.index'))
            ->post(route('dealerships.store'), ['name' => 'Super Motors'])
            ->assertRedirect(route('dealerships.index'));
    });

    it('allows Consultants to hit the store endpoint', function (): void {
        mock(CreateDealership::class)
            ->shouldReceive('handle')
            ->once()
            ->andReturn(new Dealership(['name' => 'Consultant Motors']));

        $consultant = User::factory()->create();
        $consultant->assignRole('Consultant');

        $this->actingAs($consultant)
            ->from(route('dealerships.index'))
            ->post(route('dealerships.store'), ['name' => 'Consultant Motors'])
            ->assertRedirect(route('dealerships.index'));
    });
});

describe('validation', function (): void {
    it('requires a name', function (): void {
        asSuperAdmin()
            ->from(route('dealerships.index'))
            ->post(route('dealerships.store'), [])
            ->assertRedirect(route('dealerships.index'))
            ->assertSessionHasErrors('name');
    });

    it('rejects names longer than 255 characters', function (): void {
        asSuperAdmin()
            ->from(route('dealerships.index'))
            ->post(route('dealerships.store'), ['name' => str_repeat('a', 256)])
            ->assertSessionHasErrors('name');
    });

    it('rejects names with disallowed characters', function (string $name): void {
        asSuperAdmin()
            ->from(route('dealerships.index'))
            ->post(route('dealerships.store'), ['name' => $name])
            ->assertSessionHasErrors('name');
    })->with([
        'slash' => 'Acme/Auto',
        'underscore' => 'Acme_Auto',
        'colon' => 'Acme:Auto',
        'tilde' => 'Acme~Auto',
    ]);

    it('accepts the full allowed character set', function (): void {
        mock(CreateDealership::class)
            ->shouldReceive('handle')
            ->once()
            ->andReturn(new Dealership(['name' => "O'Brien-Smith & Co. 123"]));

        asSuperAdmin()
            ->from(route('dealerships.index'))
            ->post(route('dealerships.store'), ['name' => "O'Brien-Smith & Co. 123"])
            ->assertRedirect(route('dealerships.index'))
            ->assertSessionHasNoErrors();
    });

    it('rejects a duplicate name', function (): void {
        existingDealershipNamed('Alpha Auto');

        asSuperAdmin()
            ->from(route('dealerships.index'))
            ->post(route('dealerships.store'), ['name' => 'Alpha Auto'])
            ->assertSessionHasErrors('name');
    });

    it('rejects non-array consultant_ids', function (): void {
        asSuperAdmin()
            ->from(route('dealerships.index'))
            ->post(route('dealerships.store'), [
                'name' => 'Valid Name',
                'consultant_ids' => 'not-an-array',
            ])
            ->assertSessionHasErrors('consultant_ids');
    });

    it('rejects non-integer consultant ids', function (): void {
        asSuperAdmin()
            ->from(route('dealerships.index'))
            ->post(route('dealerships.store'), [
                'name' => 'Valid Name',
                'consultant_ids' => ['not-an-int'],
            ])
            ->assertSessionHasErrors('consultant_ids.0');
    });

    it('rejects consultant ids that do not exist', function (): void {
        asSuperAdmin()
            ->from(route('dealerships.index'))
            ->post(route('dealerships.store'), [
                'name' => 'Valid Name',
                'consultant_ids' => [999999],
            ])
            ->assertSessionHasErrors('consultant_ids.0');
    });
});

describe('notifications', function (): void {
    it('dispatches NewDealershipNotification to the configured email after commit', function (): void {
        config(['services.dealership.notification_email' => 'ops@example.test']);

        mock(CreateDealership::class)
            ->shouldReceive('handle')
            ->once()
            ->andReturnUsing(function (User $user, DealershipData $data): Dealership {
                Notification::route('mail', (string) config('services.dealership.notification_email'))
                    ->notify(new NewDealershipNotification($data->name));

                return new Dealership(['name' => $data->name]);
            });

        Notification::fake();

        asSuperAdmin()
            ->from(route('dealerships.index'))
            ->post(route('dealerships.store'), ['name' => 'Notifiable Auto'])
            ->assertRedirect(route('dealerships.index'));

        Notification::assertSentTo(
            new AnonymousNotifiable,
            NewDealershipNotification::class,
            fn (NewDealershipNotification $notification, array $channels, AnonymousNotifiable $notifiable): bool => $notifiable->routes['mail'] === 'ops@example.test'
                && in_array('mail', $channels, true),
        );
    });

    it('skips the notification when no email is configured', function (): void {
        config(['services.dealership.notification_email' => '']);

        mock(CreateDealership::class)
            ->shouldReceive('handle')
            ->once()
            ->andReturn(new Dealership(['name' => 'Silent Auto']));

        Notification::fake();

        asSuperAdmin()
            ->from(route('dealerships.index'))
            ->post(route('dealerships.store'), ['name' => 'Silent Auto'])
            ->assertRedirect(route('dealerships.index'));

        Notification::assertNothingSent();
    });

    it('queues the notification with afterCommit semantics', function (): void {
        $notification = new NewDealershipNotification('Queued Auto');

        expect($notification)->toBeInstanceOf(Illuminate\Contracts\Queue\ShouldQueue::class);
        expect($notification->afterCommit)->toBeTrue();
    });
});

describe('action invocation', function (): void {
    it('passes the authenticated user and validated data through to the action', function (): void {
        $creator = User::factory()->create();
        $creator->assignRole('Consultant');

        $otherConsultant = User::factory()->create();
        $otherConsultant->assignRole('Consultant');

        mock(CreateDealership::class)
            ->shouldReceive('handle')
            ->once()
            ->withArgs(function (User $user, DealershipData $data) use ($creator, $otherConsultant): bool {
                return $user->id === $creator->id
                    && $data->name === 'Action Auto'
                    && $data->consultantIds === [$otherConsultant->id];
            })
            ->andReturn(new Dealership(['name' => 'Action Auto']));

        $this->actingAs($creator)
            ->from(route('dealerships.index'))
            ->post(route('dealerships.store'), [
                'name' => 'Action Auto',
                'consultant_ids' => [$otherConsultant->id],
            ])
            ->assertRedirect(route('dealerships.index'));
    });

    it('propagates exceptions thrown by the action', function (): void {
        mock(CreateDealership::class)
            ->shouldReceive('handle')
            ->once()
            ->andThrow(new RuntimeException('boom'));

        $this->withoutExceptionHandling();

        expect(fn () => asSuperAdmin()
            ->from(route('dealerships.index'))
            ->post(route('dealerships.store'), ['name' => 'Boom Auto']))
            ->toThrow(RuntimeException::class, 'boom');
    });
});
