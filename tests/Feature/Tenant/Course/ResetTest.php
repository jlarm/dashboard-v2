<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Course\Reset;
use App\Jobs\SendCoursesResetNotifications;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;

describe('Reset Component Rendering', function (): void {
    it('renders successfully', function (): void {
        $this->actingAs($this->consultant);

        Livewire::test(Reset::class)
            ->assertStatus(200);
    });

    it('displays reset courses button', function (): void {
        $this->actingAs($this->consultant);

        Livewire::test(Reset::class)
            ->assertSee('Reset Courses');
    });
});

describe('Reset Component Authorization', function (): void {
    it('allows consultant to reset courses', function (): void {
        $this->actingAs($this->consultant);

        $course = Course::query()->create([
            'name' => 'Test Course',
            'slug' => 'test-course',
            'slides' => [],
        ]);

        CourseResults::query()->create([
            'user_id' => $this->consultant->id,
            'course_id' => $course->id,
            'percentage' => 85,
            'passed' => true,
        ]);

        expect(CourseResults::query()->count())->toBe(1);

        Livewire::test(Reset::class)
            ->call('resetCourses')
            ->assertHasNoErrors();
    });

    it('prevents manager from resetting courses', function (): void {
        $this->actingAs($this->manager);

        Livewire::test(Reset::class)
            ->call('resetCourses')
            ->assertForbidden();
    });
});

describe('Reset All Course Results', function (): void {
    it('deletes all course results when no store is specified', function (): void {
        $this->actingAs($this->consultant);

        $course = Course::query()->create([
            'name' => 'Test Course',
            'slug' => 'test-course',
            'slides' => [],
        ]);

        $user1 = User::query()->create([
            'name' => 'User One',
            'email' => 'user1@test.com',
            'password' => bcrypt('password'),
        ]);

        $user2 = User::query()->create([
            'name' => 'User Two',
            'email' => 'user2@test.com',
            'password' => bcrypt('password'),
        ]);

        CourseResults::query()->create([
            'user_id' => $user1->id,
            'course_id' => $course->id,
            'percentage' => 85,
            'passed' => true,
        ]);

        CourseResults::query()->create([
            'user_id' => $user2->id,
            'course_id' => $course->id,
            'percentage' => 90,
            'passed' => true,
        ]);

        expect(CourseResults::query()->count())->toBe(2);

        Livewire::test(Reset::class)
            ->call('resetCourses')
            ->emit('actionConfirmed')
            ->assertHasNoErrors();

        expect(CourseResults::query()->count())->toBe(0);
    });

    it('handles empty course results gracefully', function (): void {
        $this->actingAs($this->consultant);

        expect(CourseResults::query()->count())->toBe(0);

        Livewire::test(Reset::class)
            ->call('resetCourses')
            ->emit('actionConfirmed')
            ->assertHasNoErrors();

        expect(CourseResults::query()->count())->toBe(0);
    });
});

describe('Reset Store-Specific Course Results', function (): void {
    it('deletes only store-specific course results when store is specified', function (): void {
        $this->actingAs($this->consultant);

        tenant()->update(['locations' => true]);

        $store1 = Store::query()->first();
        $store2 = Store::query()->create([
            'name' => 'Second Store',
            'slug' => 'second-store',
        ]);

        $course = Course::query()->create([
            'name' => 'Test Course',
            'slug' => 'test-course',
            'slides' => [],
        ]);

        $storeUser = User::query()->create([
            'name' => 'Store User',
            'email' => 'store-user@test.com',
            'password' => bcrypt('password'),
        ]);
        $storeUser->stores()->attach($store1->id);

        $otherStoreUser = User::query()->create([
            'name' => 'Other Store User',
            'email' => 'other-store-user@test.com',
            'password' => bcrypt('password'),
        ]);
        $otherStoreUser->stores()->attach($store2->id);

        CourseResults::query()->create([
            'user_id' => $storeUser->id,
            'course_id' => $course->id,
            'percentage' => 85,
            'passed' => true,
        ]);

        CourseResults::query()->create([
            'user_id' => $otherStoreUser->id,
            'course_id' => $course->id,
            'percentage' => 90,
            'passed' => true,
        ]);

        expect(CourseResults::query()->count())->toBe(2);

        Livewire::test(Reset::class, ['store' => $store1])
            ->call('resetCourses')
            ->emit('actionConfirmed')
            ->assertHasNoErrors();

        expect(CourseResults::query()->count())->toBe(1);
        expect(CourseResults::query()->first()->user_id)->toBe($otherStoreUser->id);
    });

    it('handles store with no users gracefully', function (): void {
        $this->actingAs($this->consultant);

        tenant()->update(['locations' => true]);

        $emptyStore = Store::query()->create([
            'name' => 'Empty Store',
            'slug' => 'empty-store',
        ]);

        $course = Course::query()->create([
            'name' => 'Test Course',
            'slug' => 'test-course',
            'slides' => [],
        ]);

        CourseResults::query()->create([
            'user_id' => $this->consultant->id,
            'course_id' => $course->id,
            'percentage' => 85,
            'passed' => true,
        ]);

        expect(CourseResults::query()->count())->toBe(1);

        Livewire::test(Reset::class, ['store' => $emptyStore])
            ->call('resetCourses')
            ->emit('actionConfirmed')
            ->assertHasNoErrors();

        expect(CourseResults::query()->count())->toBe(1);
    });
});

describe('Activity Logging', function (): void {
    it('logs activity when resetting all courses', function (): void {
        $this->actingAs($this->consultant);

        $course = Course::query()->create([
            'name' => 'Test Course',
            'slug' => 'test-course',
            'slides' => [],
        ]);

        CourseResults::query()->create([
            'user_id' => $this->consultant->id,
            'course_id' => $course->id,
            'percentage' => 85,
            'passed' => true,
        ]);

        Livewire::test(Reset::class)
            ->call('resetCourses')
            ->emit('actionConfirmed')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('activity_log', [
            'description' => 'All course results reset',
            'causer_id' => $this->consultant->id,
        ]);
    });

    it('logs activity when resetting store courses', function (): void {
        $this->actingAs($this->consultant);

        tenant()->update(['locations' => true]);

        $store = Store::query()->first();

        $storeUser = User::query()->create([
            'name' => 'Store User',
            'email' => 'store-user@test.com',
            'password' => bcrypt('password'),
        ]);
        $storeUser->stores()->attach($store->id);

        $course = Course::query()->create([
            'name' => 'Test Course',
            'slug' => 'test-course',
            'slides' => [],
        ]);

        CourseResults::query()->create([
            'user_id' => $storeUser->id,
            'course_id' => $course->id,
            'percentage' => 85,
            'passed' => true,
        ]);

        Livewire::test(Reset::class, ['store' => $store])
            ->call('resetCourses')
            ->emit('actionConfirmed')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('activity_log', [
            'description' => "Course results reset for store: {$store->name}",
            'causer_id' => $this->consultant->id,
        ]);
    });
});

describe('Email Notifications', function (): void {
    it('dispatches notification job when resetting all courses', function (): void {
        Queue::fake();

        $this->actingAs($this->consultant);

        $course = Course::query()->create([
            'name' => 'Test Course',
            'slug' => 'test-course',
            'slides' => [],
        ]);

        $user1 = User::query()->create([
            'name' => 'User One',
            'email' => 'user1@test.com',
            'password' => bcrypt('password'),
        ]);

        $user2 = User::query()->create([
            'name' => 'User Two',
            'email' => 'user2@test.com',
            'password' => bcrypt('password'),
        ]);

        CourseResults::query()->create([
            'user_id' => $user1->id,
            'course_id' => $course->id,
            'percentage' => 85,
            'passed' => true,
        ]);

        CourseResults::query()->create([
            'user_id' => $user2->id,
            'course_id' => $course->id,
            'percentage' => 90,
            'passed' => true,
        ]);

        Livewire::test(Reset::class)
            ->call('resetCourses')
            ->emit('actionConfirmed')
            ->assertHasNoErrors();

        Queue::assertPushed(SendCoursesResetNotifications::class, function ($job) use ($user1, $user2): bool {
            $userIds = $job->userIds;

            return $userIds->contains($user1->id) && $userIds->contains($user2->id);
        });
    });

    it('dispatches notification job only for affected store users', function (): void {
        Queue::fake();

        $this->actingAs($this->consultant);

        tenant()->update(['locations' => true]);

        $store1 = Store::query()->first();
        $store2 = Store::query()->create([
            'name' => 'Second Store',
            'slug' => 'second-store',
        ]);

        $course = Course::query()->create([
            'name' => 'Test Course',
            'slug' => 'test-course',
            'slides' => [],
        ]);

        $storeUser = User::query()->create([
            'name' => 'Store User',
            'email' => 'store-user@test.com',
            'password' => bcrypt('password'),
        ]);
        $storeUser->stores()->attach($store1->id);

        $otherStoreUser = User::query()->create([
            'name' => 'Other Store User',
            'email' => 'other-store-user@test.com',
            'password' => bcrypt('password'),
        ]);
        $otherStoreUser->stores()->attach($store2->id);

        CourseResults::query()->create([
            'user_id' => $storeUser->id,
            'course_id' => $course->id,
            'percentage' => 85,
            'passed' => true,
        ]);

        CourseResults::query()->create([
            'user_id' => $otherStoreUser->id,
            'course_id' => $course->id,
            'percentage' => 90,
            'passed' => true,
        ]);

        Livewire::test(Reset::class, ['store' => $store1])
            ->call('resetCourses')
            ->emit('actionConfirmed')
            ->assertHasNoErrors();

        Queue::assertPushed(SendCoursesResetNotifications::class, function ($job) use ($storeUser, $otherStoreUser): bool {
            $userIds = $job->userIds;

            return $userIds->contains($storeUser->id) && ! $userIds->contains($otherStoreUser->id);
        });
    });

    it('does not dispatch notification job when no courses are reset', function (): void {
        Queue::fake();

        $this->actingAs($this->consultant);

        expect(CourseResults::query()->count())->toBe(0);

        Livewire::test(Reset::class)
            ->call('resetCourses')
            ->emit('actionConfirmed')
            ->assertHasNoErrors();

        Queue::assertNotPushed(SendCoursesResetNotifications::class);
    });
});
