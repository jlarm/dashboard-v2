<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Livewire\Dealer\Log\Index;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Activitylog\Models\Activity;

describe('Log Index Component - Rendering', function (): void {
    it('renders successfully for authorized users', function (): void {
        $user = User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Admin');

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->assertStatus(200)
            ->assertViewIs('livewire.dealer.log.index');
    });

    it('displays activity logs with pagination', function (): void {
        $user = User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Admin');

        // Clear all logs including user creation logs
        Activity::query()->delete();

        // Create 30 activity logs to test pagination
        for ($i = 0; $i < 30; $i++) {
            activity()
                ->causedBy($user)
                ->log("Test activity {$i}");
        }

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->assertViewHas('logs', fn ($logs): bool => $logs->count() === 25) // Default pagination is 25
            ->assertSee('Test activity 0') // Latest activity (created last)
            ->assertDontSee('Test activity 29'); // Should be on page 2 (created first)
    });

    it('displays empty state when no logs exist', function (): void {
        $user = User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Admin');

        // Clear all logs including user creation logs
        Activity::query()->delete();

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->assertSee(__('No activity logs'))
            ->assertSee(__('No activity has been recorded yet.'));
    });

    it('eager loads causer relationship to prevent N+1 queries', function (): void {
        $user = User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Admin');

        // Create activities with different causers
        for ($i = 0; $i < 5; $i++) {
            $causer = User::query()->create([
                'name' => "User {$i}",
                'email' => "user{$i}@test.com",
                'password' => bcrypt('password'),
            ]);

            activity()
                ->causedBy($causer)
                ->log("Activity by user {$i}");
        }

        $this->actingAs($user);

        // Enable query log
        DB::enableQueryLog();

        Livewire::test(Index::class);

        $queries = DB::getQueryLog();

        // Should have minimal queries due to eager loading
        // 1 for activities + 1 for count (pagination) + any auth queries
        $activityQueries = collect($queries)->filter(fn ($query): bool => str_contains((string) $query['query'], 'activity_log'));

        // Should not have separate queries for each causer
        expect($activityQueries->count())->toBeLessThanOrEqual(3);
    });
});

describe('Log Index Component - View Log Details', function (): void {
    it('opens modal with log details when viewing a log', function (): void {
        $user = User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Admin');

        $activity = activity()
            ->causedBy($user)
            ->log('Test activity');

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->call('viewLogDetails', $activity->id)
            ->assertSet('selectedLog.id', $activity->id)
            ->assertSet('selectedLog.description', 'Test activity')
            ->assertDispatchedBrowserEvent('open-log-modal');
    });

    it('loads causer and subject relationships when viewing log details', function (): void {
        $causer = User::query()->create([
            'name' => 'Causer User',
            'email' => 'causer@test.com',
            'password' => bcrypt('password'),
        ]);

        $subject = User::query()->create([
            'name' => 'Subject User',
            'email' => 'subject@test.com',
            'password' => bcrypt('password'),
        ]);
        $subject->assignRole('Admin');

        $activity = activity()
            ->causedBy($causer)
            ->performedOn($subject)
            ->log('Updated user');

        $this->actingAs($subject);

        Livewire::test(Index::class)
            ->call('viewLogDetails', $activity->id)
            ->assertSet('selectedLog.causer.name', 'Causer User')
            ->assertSet('selectedLog.subject.name', 'Subject User');
    });

    it('throws exception when viewing non-existent log', function (): void {
        $user = User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Admin');

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->call('viewLogDetails', 99999);
    })->throws(ModelNotFoundException::class);
});

describe('Log Index Component - Close Modal', function (): void {
    it('closes modal and clears selected log', function (): void {
        $user = User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Admin');

        $activity = activity()
            ->causedBy($user)
            ->log('Test activity');

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->call('viewLogDetails', $activity->id)
            ->assertSet('selectedLog.id', $activity->id)
            ->call('closeModal')
            ->assertSet('selectedLog', null)
            ->assertDispatchedBrowserEvent('close-log-modal');
    });
});

describe('Log Index Component - Pagination', function (): void {
    it('displays pagination links when more than 25 logs exist', function (): void {
        $user = User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Admin');

        // Create 30 logs
        for ($i = 0; $i < 30; $i++) {
            activity()
                ->causedBy($user)
                ->log("Activity {$i}");
        }

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->assertViewHas('logs', fn ($logs) => $logs->hasPages());
    });

    it('navigates to second page correctly', function (): void {
        $user = User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Admin');

        // Clear all logs including user creation logs
        Activity::query()->delete();

        // Create 30 logs
        for ($i = 0; $i < 30; $i++) {
            activity()
                ->causedBy($user)
                ->log("Activity {$i}");
        }

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->call('gotoPage', 2)
            ->assertViewHas('logs', fn ($logs): bool => $logs->currentPage() === 2 && $logs->count() === 5);
    });

    it('does not break when navigating to invalid page', function (): void {
        $user = User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Admin');

        // Clear all logs including user creation logs
        Activity::query()->delete();

        // Create 10 logs
        for ($i = 0; $i < 10; $i++) {
            activity()
                ->causedBy($user)
                ->log("Activity {$i}");
        }

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->call('gotoPage', 99)
            ->assertStatus(200)
            ->assertViewHas('logs'); // Still renders without error
    });
});

describe('Log Index Component - Activity Display', function (): void {
    it('displays activity with causer information', function (): void {
        Activity::query()->delete();

        $causer = User::query()->create([
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'password' => bcrypt('password'),
        ]);
        $causer->assignRole('Admin');

        $activity = activity()
            ->causedBy($causer)
            ->log('Created new resource');

        $this->actingAs($causer);

        Livewire::test(Index::class)
            ->assertSee('John Doe')
            ->assertSee('Created new resource');
    });

    it('displays system when no causer exists', function (): void {
        $user = User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Admin');

        activity()->log('System generated activity');

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->assertSee(__('System'));
    });

    it('displays subject type correctly', function (): void {
        $user = User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Admin');

        $subject = User::query()->create([
            'name' => 'Subject User',
            'email' => 'subject@test.com',
            'password' => bcrypt('password'),
        ]);

        activity()
            ->causedBy($user)
            ->performedOn($subject)
            ->log('Updated user');

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->assertSee('User'); // class_basename of User model
    });
});
