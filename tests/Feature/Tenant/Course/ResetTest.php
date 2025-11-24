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

describe('Reset Component Rendering', function () {
    it('renders successfully', function () {
        $this->actingAs($this->consultant);

        Livewire::test(Reset::class)
            ->assertStatus(200);
    });

    it('displays reset courses button', function () {
        $this->actingAs($this->consultant);

        Livewire::test(Reset::class)
            ->assertSee('Reset Courses');
    });
});

describe('Reset Component Authorization', function () {
    it('allows consultant to reset courses', function () {
        $this->actingAs($this->consultant);

        $course = Course::create([
            'name' => 'Test Course',
            'slug' => 'test-course',
            'slides' => [],
        ]);

        CourseResults::create([
            'user_id' => $this->consultant->id,
            'course_id' => $course->id,
            'percentage' => 85,
            'passed' => true,
        ]);

        expect(CourseResults::count())->toBe(1);

        Livewire::test(Reset::class)
            ->call('resetCourses')
            ->assertHasNoErrors();
    });

    it('prevents manager from resetting courses', function () {
        $this->actingAs($this->manager);

        Livewire::test(Reset::class)
            ->call('resetCourses')
            ->assertForbidden();
    });
});

describe('Reset All Course Results', function () {
    it('deletes all course results when no store is specified', function () {
        $this->actingAs($this->consultant);

        $course = Course::create([
            'name' => 'Test Course',
            'slug' => 'test-course',
            'slides' => [],
        ]);

        $user1 = User::create([
            'name' => 'User One',
            'email' => 'user1@test.com',
            'password' => bcrypt('password'),
        ]);

        $user2 = User::create([
            'name' => 'User Two',
            'email' => 'user2@test.com',
            'password' => bcrypt('password'),
        ]);

        CourseResults::create([
            'user_id' => $user1->id,
            'course_id' => $course->id,
            'percentage' => 85,
            'passed' => true,
        ]);

        CourseResults::create([
            'user_id' => $user2->id,
            'course_id' => $course->id,
            'percentage' => 90,
            'passed' => true,
        ]);

        expect(CourseResults::count())->toBe(2);

        Livewire::test(Reset::class)
            ->call('resetCourses')
            ->emit('actionConfirmed')
            ->assertHasNoErrors();

        expect(CourseResults::count())->toBe(0);
    });

    it('handles empty course results gracefully', function () {
        $this->actingAs($this->consultant);

        expect(CourseResults::count())->toBe(0);

        Livewire::test(Reset::class)
            ->call('resetCourses')
            ->emit('actionConfirmed')
            ->assertHasNoErrors();

        expect(CourseResults::count())->toBe(0);
    });
});

describe('Reset Store-Specific Course Results', function () {
    it('deletes only store-specific course results when store is specified', function () {
        $this->actingAs($this->consultant);

        tenant()->update(['locations' => true]);

        $store1 = Store::first();
        $store2 = Store::create([
            'name' => 'Second Store',
            'slug' => 'second-store',
        ]);

        $course = Course::create([
            'name' => 'Test Course',
            'slug' => 'test-course',
            'slides' => [],
        ]);

        $storeUser = User::create([
            'name' => 'Store User',
            'email' => 'store-user@test.com',
            'password' => bcrypt('password'),
        ]);
        $storeUser->stores()->attach($store1->id);

        $otherStoreUser = User::create([
            'name' => 'Other Store User',
            'email' => 'other-store-user@test.com',
            'password' => bcrypt('password'),
        ]);
        $otherStoreUser->stores()->attach($store2->id);

        CourseResults::create([
            'user_id' => $storeUser->id,
            'course_id' => $course->id,
            'percentage' => 85,
            'passed' => true,
        ]);

        CourseResults::create([
            'user_id' => $otherStoreUser->id,
            'course_id' => $course->id,
            'percentage' => 90,
            'passed' => true,
        ]);

        expect(CourseResults::count())->toBe(2);

        Livewire::test(Reset::class, ['store' => $store1])
            ->call('resetCourses')
            ->emit('actionConfirmed')
            ->assertHasNoErrors();

        expect(CourseResults::count())->toBe(1);
        expect(CourseResults::first()->user_id)->toBe($otherStoreUser->id);
    });

    it('handles store with no users gracefully', function () {
        $this->actingAs($this->consultant);

        tenant()->update(['locations' => true]);

        $emptyStore = Store::create([
            'name' => 'Empty Store',
            'slug' => 'empty-store',
        ]);

        $course = Course::create([
            'name' => 'Test Course',
            'slug' => 'test-course',
            'slides' => [],
        ]);

        CourseResults::create([
            'user_id' => $this->consultant->id,
            'course_id' => $course->id,
            'percentage' => 85,
            'passed' => true,
        ]);

        expect(CourseResults::count())->toBe(1);

        Livewire::test(Reset::class, ['store' => $emptyStore])
            ->call('resetCourses')
            ->emit('actionConfirmed')
            ->assertHasNoErrors();

        expect(CourseResults::count())->toBe(1);
    });
});

describe('Activity Logging', function () {
    it('logs activity when resetting all courses', function () {
        $this->actingAs($this->consultant);

        $course = Course::create([
            'name' => 'Test Course',
            'slug' => 'test-course',
            'slides' => [],
        ]);

        CourseResults::create([
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

    it('logs activity when resetting store courses', function () {
        $this->actingAs($this->consultant);

        tenant()->update(['locations' => true]);

        $store = Store::first();

        $storeUser = User::create([
            'name' => 'Store User',
            'email' => 'store-user@test.com',
            'password' => bcrypt('password'),
        ]);
        $storeUser->stores()->attach($store->id);

        $course = Course::create([
            'name' => 'Test Course',
            'slug' => 'test-course',
            'slides' => [],
        ]);

        CourseResults::create([
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

describe('Email Notifications', function () {
    it('dispatches notification job when resetting all courses', function () {
        Queue::fake();

        $this->actingAs($this->consultant);

        $course = Course::create([
            'name' => 'Test Course',
            'slug' => 'test-course',
            'slides' => [],
        ]);

        $user1 = User::create([
            'name' => 'User One',
            'email' => 'user1@test.com',
            'password' => bcrypt('password'),
        ]);

        $user2 = User::create([
            'name' => 'User Two',
            'email' => 'user2@test.com',
            'password' => bcrypt('password'),
        ]);

        CourseResults::create([
            'user_id' => $user1->id,
            'course_id' => $course->id,
            'percentage' => 85,
            'passed' => true,
        ]);

        CourseResults::create([
            'user_id' => $user2->id,
            'course_id' => $course->id,
            'percentage' => 90,
            'passed' => true,
        ]);

        Livewire::test(Reset::class)
            ->call('resetCourses')
            ->emit('actionConfirmed')
            ->assertHasNoErrors();

        Queue::assertPushed(SendCoursesResetNotifications::class, function ($job) use ($user1, $user2) {
            $userIds = $job->userIds;

            return $userIds->contains($user1->id) && $userIds->contains($user2->id);
        });
    });

    it('dispatches notification job only for affected store users', function () {
        Queue::fake();

        $this->actingAs($this->consultant);

        tenant()->update(['locations' => true]);

        $store1 = Store::first();
        $store2 = Store::create([
            'name' => 'Second Store',
            'slug' => 'second-store',
        ]);

        $course = Course::create([
            'name' => 'Test Course',
            'slug' => 'test-course',
            'slides' => [],
        ]);

        $storeUser = User::create([
            'name' => 'Store User',
            'email' => 'store-user@test.com',
            'password' => bcrypt('password'),
        ]);
        $storeUser->stores()->attach($store1->id);

        $otherStoreUser = User::create([
            'name' => 'Other Store User',
            'email' => 'other-store-user@test.com',
            'password' => bcrypt('password'),
        ]);
        $otherStoreUser->stores()->attach($store2->id);

        CourseResults::create([
            'user_id' => $storeUser->id,
            'course_id' => $course->id,
            'percentage' => 85,
            'passed' => true,
        ]);

        CourseResults::create([
            'user_id' => $otherStoreUser->id,
            'course_id' => $course->id,
            'percentage' => 90,
            'passed' => true,
        ]);

        Livewire::test(Reset::class, ['store' => $store1])
            ->call('resetCourses')
            ->emit('actionConfirmed')
            ->assertHasNoErrors();

        Queue::assertPushed(SendCoursesResetNotifications::class, function ($job) use ($storeUser, $otherStoreUser) {
            $userIds = $job->userIds;

            return $userIds->contains($storeUser->id) && ! $userIds->contains($otherStoreUser->id);
        });
    });

    it('does not dispatch notification job when no courses are reset', function () {
        Queue::fake();

        $this->actingAs($this->consultant);

        expect(CourseResults::count())->toBe(0);

        Livewire::test(Reset::class)
            ->call('resetCourses')
            ->emit('actionConfirmed')
            ->assertHasNoErrors();

        Queue::assertNotPushed(SendCoursesResetNotifications::class);
    });
});
