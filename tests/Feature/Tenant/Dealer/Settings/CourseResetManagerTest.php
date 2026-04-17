<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Settings\CourseResetManager;
use App\Jobs\SendCoursesResetNotifications;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();

    $this->superAdmin = User::query()->create([
        'name' => 'Course Reset Super Admin',
        'email' => 'course-reset-super-admin@test.com',
        'password' => bcrypt('password'),
    ]);
    $this->superAdmin->assignRole('super-admin');
    $this->superAdmin->stores()->sync([$this->store->id]);

    app()[PermissionRegistrar::class]->forgetCachedPermissions();
});

it('renders the global course reset manager', function (): void {
    $this->actingAs($this->superAdmin);

    Livewire::test(CourseResetManager::class)
        ->assertSee('Reset Courses')
        ->assertSee('Everyone')
        ->assertSee('Select Users')
        ->assertSee('Reset All Courses');
});

it('filters users in selected-users mode', function (): void {
    $this->actingAs($this->superAdmin);

    $jane = User::query()->create([
        'name' => 'Jane Employee',
        'email' => 'jane.employee@test.com',
        'password' => bcrypt('password'),
    ]);
    $jane->assignRole('Employee');
    $jane->stores()->sync([$this->store->id]);

    $john = User::query()->create([
        'name' => 'John Employee',
        'email' => 'john.employee@test.com',
        'password' => bcrypt('password'),
    ]);
    $john->assignRole('Employee');
    $john->stores()->sync([$this->store->id]);

    Livewire::test(CourseResetManager::class)
        ->call('setMode', 'selected-users')
        ->set('search', 'Jane')
        ->assertSee('Jane Employee')
        ->assertDontSee('John Employee');
});

it('renders selected-users mode for users with whitespace-only names', function (): void {
    $this->actingAs($this->superAdmin);

    $user = User::query()->create([
        'name' => '   ',
        'email' => 'whitespace-name@test.com',
        'password' => bcrypt('password'),
    ]);
    $user->assignRole('Employee');
    $user->stores()->sync([$this->store->id]);

    Livewire::test(CourseResetManager::class)
        ->call('setMode', 'selected-users')
        ->assertSee('whitespace-name@test.com');
});

it('requires at least one selected user when resetting selected users', function (): void {
    $this->actingAs($this->superAdmin);

    Livewire::test(CourseResetManager::class)
        ->call('setMode', 'selected-users')
        ->call('resetCourses')
        ->assertHasErrors(['selectedUserIds']);
});

it('toggles selected users when a row is clicked', function (): void {
    $this->actingAs($this->superAdmin);

    $user = User::query()->create([
        'name' => 'Row Toggle User',
        'email' => 'row-toggle-user@test.com',
        'password' => bcrypt('password'),
    ]);
    $user->assignRole('Employee');
    $user->stores()->sync([$this->store->id]);

    Livewire::test(CourseResetManager::class)
        ->call('setMode', 'selected-users')
        ->call('toggleSelectedUser', $user->id)
        ->assertSet('selectedUserIds', [$user->id])
        ->call('toggleSelectedUser', $user->id)
        ->assertSet('selectedUserIds', []);
});

it('resets only the selected users course results', function (): void {
    Queue::fake();

    $this->actingAs($this->superAdmin);

    $course = Course::query()->create([
        'name' => 'Reset Target Course',
        'slug' => 'reset-target-course',
        'slides' => [],
    ]);

    $userOne = User::query()->create([
        'name' => 'Reset User One',
        'email' => 'reset-user-one@test.com',
        'password' => bcrypt('password'),
    ]);
    $userOne->assignRole('Employee');
    $userOne->stores()->sync([$this->store->id]);

    $userTwo = User::query()->create([
        'name' => 'Reset User Two',
        'email' => 'reset-user-two@test.com',
        'password' => bcrypt('password'),
    ]);
    $userTwo->assignRole('Employee');
    $userTwo->stores()->sync([$this->store->id]);

    $userThree = User::query()->create([
        'name' => 'Reset User Three',
        'email' => 'reset-user-three@test.com',
        'password' => bcrypt('password'),
    ]);
    $userThree->assignRole('Employee');
    $userThree->stores()->sync([$this->store->id]);

    CourseResults::query()->create([
        'user_id' => $userOne->id,
        'course_id' => $course->id,
        'percentage' => 80,
        'passed' => true,
    ]);

    CourseResults::query()->create([
        'user_id' => $userTwo->id,
        'course_id' => $course->id,
        'percentage' => 85,
        'passed' => true,
    ]);

    CourseResults::query()->create([
        'user_id' => $userThree->id,
        'course_id' => $course->id,
        'percentage' => 90,
        'passed' => true,
    ]);

    Livewire::test(CourseResetManager::class)
        ->call('setMode', 'selected-users')
        ->set('selectedUserIds', [$userOne->id, $userTwo->id])
        ->call('resetCourses')
        ->dispatch('actionConfirmed')
        ->assertHasNoErrors();

    expect(CourseResults::query()->pluck('user_id')->all())->toBe([$userThree->id]);

    Queue::assertPushed(SendCoursesResetNotifications::class, function ($job) use ($userOne, $userTwo, $userThree): bool {
        $userIds = $job->userIds;

        return $userIds->contains($userOne->id)
            && $userIds->contains($userTwo->id)
            && ! $userIds->contains($userThree->id);
    });

    $this->assertDatabaseHas('activity_log', [
        'description' => 'Course results reset for selected users',
        'causer_id' => $this->superAdmin->id,
    ]);
});

it('limits selected-users mode to employees in the provided store', function (): void {
    $this->actingAs($this->superAdmin);

    $otherStore = Store::query()->create([
        'name' => 'Other Reset Store',
        'slug' => 'other-reset-store',
    ]);

    $inStoreUser = User::query()->create([
        'name' => 'In Store User',
        'email' => 'in-store-user@test.com',
        'password' => bcrypt('password'),
    ]);
    $inStoreUser->assignRole('Employee');
    $inStoreUser->stores()->sync([$this->store->id]);

    $otherStoreUser = User::query()->create([
        'name' => 'Other Store User',
        'email' => 'other-reset-user@test.com',
        'password' => bcrypt('password'),
    ]);
    $otherStoreUser->assignRole('Employee');
    $otherStoreUser->stores()->sync([$otherStore->id]);

    Livewire::test(CourseResetManager::class, ['store' => $this->store])
        ->call('setMode', 'selected-users')
        ->assertSee('In Store User')
        ->assertDontSee('Other Store User');
});
